import re
import fitz  # PyMuPDF
from flask import Flask, request, jsonify
from sentence_transformers import SentenceTransformer, util

app = Flask(__name__)

# ---------------- CONFIG ----------------
EDUCATION_LEVELS = {
    'high school': 1, 'associate': 2, 'bachelor': 3, 'bsc': 3, 'b.sc': 3,
    'master': 4, 'msc': 4, 'm.sc': 4, 'phd': 5, 'doctorate': 5,
}

SKILL_KEYWORDS = {
    "python", "django", "flask", "rest", "restful", "api", "aws", "gcp", "azure",
    "docker", "kubernetes", "git", "sql", "mysql", "postgres", "mongodb",
    "html", "css", "javascript", "react", "vue", "node.js", "linux", "bash"
}

# ---------------- UTILITIES ----------------
def extract_experience(text):
    matches = re.findall(r'(\d+)\+?\s*(?:years|yrs)', text.lower())
    return max(int(x) for x in matches) if matches else None

def extract_education_level(text):
    text = text.lower()
    return max([EDUCATION_LEVELS[level] for level in EDUCATION_LEVELS if level in text], default=None)

def extract_skills(text):
    text = text.lower()
    return set(skill for skill in SKILL_KEYWORDS if skill in text)

def compare_experience(resume_exp, jd_exp):
    if jd_exp is None:
        return 1
    if resume_exp is None:
        return 0
    return int(resume_exp >= jd_exp)

def compare_education(resume_edu, jd_edu):
    if jd_edu is None:
        return 1
    if resume_edu is None:
        return 0
    return int(resume_edu >= jd_edu)

def compare_skills(resume_skills, jd_skills):
    if not jd_skills:
        return 1.0
    if not resume_skills:
        return 0.0
    return len(resume_skills & jd_skills) / len(jd_skills)

def extract_text_from_pdf(file_stream):
    pdf = fitz.open(stream=file_stream.read(), filetype="pdf")
    text = ""
    for page in pdf:
        text += page.get_text()
    return text

# ---------------- CLASSIFIER ----------------
class ResumeClassifier:
    def __init__(self, model_name='all-MiniLM-L6-v2', threshold=0.75,
                 weights={'semantic': 0.5, 'experience': 0.2, 'education': 0.1, 'skills': 0.2}):
        self.model = SentenceTransformer(model_name)
        self.threshold = threshold
        self.weights = weights

    def classify(self, resume_text, jd_text):
        resume_exp = extract_experience(resume_text)
        jd_exp = extract_experience(jd_text)

        resume_edu = extract_education_level(resume_text)
        jd_edu = extract_education_level(jd_text)

        resume_skills = extract_skills(resume_text)
        jd_skills = extract_skills(jd_text)

        resume_emb = self.model.encode(resume_text, convert_to_tensor=True)
        jd_emb = self.model.encode(jd_text, convert_to_tensor=True)
        semantic_sim = util.pytorch_cos_sim(resume_emb, jd_emb).item()

        exp_match = compare_experience(resume_exp, jd_exp)
        edu_match = compare_education(resume_edu, jd_edu)
        skill_score = compare_skills(resume_skills, jd_skills)

        final_score = (
            self.weights['semantic'] * semantic_sim +
            self.weights['experience'] * exp_match +
            self.weights['education'] * edu_match +
            self.weights['skills'] * skill_score
        )

        label = "Recommended" if final_score >= self.threshold else "Not Recommended"

        return {
            'label': label,
            'final_score': round(final_score, 3),
            'semantic_similarity': round(semantic_sim, 3),
            'experience_match': exp_match,
            'education_match': edu_match,
            'skill_match_score': round(skill_score, 3),
            'resume_experience': resume_exp,
            'jd_experience': jd_exp,
            'resume_education_level': resume_edu,
            'jd_education_level': jd_edu,
            'resume_skills': list(resume_skills),
            'jd_skills': list(jd_skills)
        }

classifier = ResumeClassifier()

# ---------------- API ROUTE ----------------
@app.route("/api/classify", methods=["POST"])
def classify_resume_api():
    resume_file = request.files.get("resume")
    jd_text = request.form.get("jd", "")

    if not resume_file or not jd_text:
        return jsonify({"error": "Both 'resume' (PDF) and 'jd' (text) are required."}), 400

    try:
        resume_text = extract_text_from_pdf(resume_file)
    except Exception as e:
        return jsonify({"error": "Failed to extract text from PDF", "details": str(e)}), 500

    result = classifier.classify(resume_text, jd_text)
    return jsonify(result)

# ---------------- MAIN ----------------
if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000, debug=True)
