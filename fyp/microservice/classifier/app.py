import re
import fitz  # PyMuPDF
from flask import Flask, request, jsonify
from sentence_transformers import SentenceTransformer, util
import csv

app = Flask(__name__)

# ---------------- CONFIG ----------------
EDUCATION_LEVELS = {
    'high school': 1, 'associate': 2, 'bachelor': 3, 'bsc': 3, 'b.sc': 3,
    'master': 4, 'msc': 4, 'm.sc': 4, 'phd': 5, 'doctorate': 5,
}

def load_all_skills_from_csv(path):
    skills = set()
    with open(path, newline='', encoding='utf-8') as csvfile:
        reader = csv.DictReader(csvfile)
        for row in reader:
            skill = row['Skill'].strip().lower()
            if skill:
                skills.add(skill)
    return skills

SKILL_KEYWORDS = {
    "python", "java", "c", "c++", "c#", "javascript", "typescript",
    "ruby", "php", "swift", "kotlin", "go", "rust", "scala",
    "html", "css", "sass", "less", "tailwindcss", "bootstrap",
    "react", "vue", "angular", "svelte", "ember",
    "node.js", "express", "django", "flask", "spring", "laravel",
    "graphql", "rest", "soap", "grpc",
    "mysql", "postgresql", "mongodb", "redis", "sqlite", "oracle",
    "aws", "azure", "google cloud", "gcp", "digitalocean",
    "docker", "kubernetes", "terraform", "ansible", "jenkins", "gitlab ci",
    "git", "github", "bitbucket", "svn",
    "linux", "bash", "powershell", "zsh",
    "tensorflow", "pytorch", "keras", "scikit-learn", "opencv",
    "machine learning", "deep learning", "nlp", "computer vision",
    "data science", "big data", "hadoop", "spark",
    "apache kafka", "rabbitmq",
    "unity", "unreal engine", "godot",
    "agile", "scrum", "kanban", "jira", "confluence",
    "salesforce", "tableau", "power bi",
    "devops", "ci/cd", "microservices", "restful api",
    "graphql api", "oauth", "jwt",
    "html5", "css3", "webassembly",
    "firebase", "socket.io", "electron", "cordova", "flutter", "react native",
    "wordpress", "drupal", "magento",
    "seo", "sem", "content marketing",
    "jira", "trello", "asana",
    "cicd", "prometheus", "grafana",
    "networking", "tcp/ip", "udp",
    "blockchain", "solidity", "ethereum", "cryptocurrency",
    "photo editing", "adobe photoshop", "adobe illustrator",
    "video editing", "premiere pro", "after effects",
    "testing", "selenium", "cypress", "jest", "mocha", "chai",
    "graphql", "apollo",
    "mobile development", "android", "ios",
    "rest api", "soap api",
    "unit testing", "integration testing", "tdd", "bdd",
    "firebase", "mongodb atlas", "heroku", "netlify",
    "apache", "nginx",
    "web security", "penetration testing", "vulnerability assessment",
    "design patterns", "object oriented programming", "functional programming",
    "data structures", "algorithms",
    "excel", "microsoft office",
    "cassandra", "elastic search",
    "etl", "data warehousing",
    "jira", "confluence",
    "salesforce", "zoho crm"
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

    def classify(self, resume_text, jd_text, threshold):
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

        label = "Recommended" if final_score >= float(threshold) else "Not Recommended"

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
    threshold = request.form.get("threshold")

    if not resume_file or not jd_text:
        return jsonify({"error": "Both 'resume' (PDF) and 'jd' (text) are required."}), 400

    try:
        resume_text = extract_text_from_pdf(resume_file)
    except Exception as e:
        return jsonify({"error": "Failed to extract text from PDF", "details": str(e)}), 500

    result = classifier.classify(resume_text, jd_text, threshold)
    return jsonify(result)

# ---------------- MAIN ----------------
if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000, debug=True)
