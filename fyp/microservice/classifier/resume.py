import re
from flask import Flask, request, render_template_string
from sentence_transformers import SentenceTransformer, util
import fitz  # PyMuPDF to extract PDF text

app = Flask(__name__)

# --- Your existing extraction and classification code here ---

EDUCATION_LEVELS = {
    'high school': 1,
    'associate': 2,
    'bachelor': 3,
    'bsc': 3,
    'b.sc': 3,
    'master': 4,
    'msc': 4,
    'm.sc': 4,
    'phd': 5,
    'doctorate': 5,
}

SKILL_KEYWORDS = {
    "python", "django", "flask", "rest", "restful", "api", "aws", "gcp", "azure",
    "docker", "kubernetes", "git", "sql", "mysql", "postgres", "mongodb",
    "html", "css", "javascript", "react", "vue", "node.js", "linux", "bash",
    "laravel", "backend", "Laravel"
}

def extract_experience(text):
    matches = re.findall(r'(\d+)\+?\s*(?:years|yrs)', text.lower())
    if matches:
        return max(int(x) for x in matches)
    return None

def extract_education_level(text):
    text = text.lower()
    found_levels = []
    for level in EDUCATION_LEVELS:
        if level in text:
            found_levels.append(EDUCATION_LEVELS[level])
    return max(found_levels) if found_levels else None

def extract_skills(text):
    text = text.lower()
    return set(skill for skill in SKILL_KEYWORDS if skill in text)

def compare_experience(resume_exp, jd_exp):
    if jd_exp is None:
        return 1
    if resume_exp is None:
        return 0
    return 1 if resume_exp >= jd_exp else 0

def compare_education(resume_edu, jd_edu):
    if jd_edu is None:
        return 1
    if resume_edu is None:
        return 0
    return 1 if resume_edu >= jd_edu else 0

def compare_skills(resume_skills, jd_skills):
    if not jd_skills:
        return 1.0
    if not resume_skills:
        return 0.0
    return len(resume_skills & jd_skills) / len(jd_skills)

class ResumeClassifier:
    def __init__(self, model_name='all-mpnet-base-v2', threshold=0.75,
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
            'resume_skills': resume_skills,
            'jd_skills': jd_skills,
        }

classifier = ResumeClassifier()

# --- PDF text extraction helper ---
def extract_text_from_pdf(file_stream):
    doc = fitz.open(stream=file_stream.read(), filetype="pdf")
    text = ""
    for page in doc:
        text += page.get_text()
    return text

# --- Flask routes ---

HTML = '''
<!doctype html>
<title>Resume Classifier</title>
<h2>Upload Resume PDF and Enter Job Description</h2>
<form method=post enctype=multipart/form-data>
  <label>Resume PDF:</label><br>
  <input type=file name=resume accept="application/pdf" required><br><br>
  <label>Job Description:</label><br>
  <textarea name=jd rows=6 cols=60 required></textarea><br><br>
  <input type=submit value=Classify>
</form>

{% if result %}
<hr>
<h3>Classification Result</h3>
<p><b>Label:</b> {{ result.label }}</p>
<p><b>Final Score:</b> {{ result.final_score }}</p>
<p><b>Semantic Similarity:</b> {{ result.semantic_similarity }}</p>
<p><b>Experience Match:</b> {{ result.experience_match }} (Resume: {{ result.resume_experience }} yrs, JD: {{ result.jd_experience }} yrs)</p>
<p><b>Education Match:</b> {{ result.education_match }} (Resume Level: {{ result.resume_education_level }}, JD Level: {{ result.jd_education_level }})</p>
<p><b>Skill Match Score:</b> {{ result.skill_match_score }}</p>
<p><b>Resume Skills:</b> {{ result.resume_skills }}</p>
<p><b>JD Skills:</b> {{ result.jd_skills }}</p>
{% endif %}
'''

@app.route('/', methods=['GET', 'POST'])
def index():
    result = None
    if request.method == 'POST':
        resume_file = request.files.get('resume')
        jd_text = request.form.get('jd', '')

        if resume_file and jd_text:
            # Extract text from uploaded PDF
            resume_text = extract_text_from_pdf(resume_file.stream)
            # Classify
            result = classifier.classify(resume_text, jd_text)

    return render_template_string(HTML, result=result)

if __name__ == '__main__':
    app.run(debug=True)
