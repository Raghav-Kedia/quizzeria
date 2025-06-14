# Quizzeria 🎓

**Quizzeria** is a full-stack quiz web application that allows users to create, attempt, and review quizzes. Built with a modern frontend using Svelte and a simple backend with PHP and MySQL, it also integrates Firebase for Google authentication.

---

## 🌐 Live Demo

> _Not deployed yet._ You can run it locally using the steps below.

---

## 🚀 Features

-   🔐 **Login with Google** via Firebase
-   🧠 **Create Custom Quizzes** with multiple questions
-   📝 **Attempt Quizzes** using quiz IDs
-   📊 **Track Scores** for attempted quizzes
-   📈 **View Attempts** for quizzes you've created
-   🎨 Clean and responsive UI built with Svelte

---

## 🛠️ Tech Stack

| Layer     | Tech Used                    |
| --------- | ---------------------------- |
| Frontend  | [Svelte](https://svelte.dev) |
| Backend   | PHP (REST-style APIs)        |
| Database  | MySQL                        |
| Auth      | Firebase (Google Login)      |
| Dev Tools | Rollup, RxFire, Sirv         |

---

## 📁 Project Structure

```
quizzeria/
├── backend/quizAppAPI/    # PHP API for DB operations
├── frontend/quizApp/      # Svelte SPA frontend
├── Preview/               # (Optional)
└── README.md              # You're reading it!
```

---

## 🔧 Local Setup

### 1️⃣ Backend (PHP + MySQL)

-   Install [XAMPP](https://www.apachefriends.org/index.html) or similar
-   Move `backend/quizAppAPI/` to your server directory (e.g. `htdocs/quizzeria/`)
-   Import MySQL schema manually (you'll need to create tables: `users`, `quizzes`, `quiz_questions`, `attempts`)
-   Update credentials in `db_connection.php` if needed

### 2️⃣ Frontend (Svelte)

```bash
cd frontend/quizApp
npm install
npm run dev
```

Navigate to: [http://localhost:8080](http://localhost:8080)

> Ensure that your `firebase.js` is filled with valid credentials from your Firebase project.

---

## 🧪 Firebase Setup

1. Go to [Firebase Console](https://console.firebase.google.com/)
2. Create a new project
3. Enable **Authentication → Google Sign-In**
4. Get your config values and paste them in `frontend/quizApp/src/firebase.js`

```js
const firebaseConfig = {
    apiKey: "...",
    authDomain: "...",
    projectId: "...",
    // ...other values
};
```

---

## 🧩 Database Tables (Schema Overview)

-   `users(email)`
-   `quizzes(quiz_id, user_email)`
-   `quiz_questions(quiz_id, question_text, option1, option2, option3, option4, correct_option)`
-   `attempts(user_email, quiz_id, score)`

> _Note: You must create these tables manually or through a `.sql` dump._

---

## 📸 Screenshots

| Login                  | Create Quiz               | Attempt Quiz             | View Results             |
| ---------------------- | ------------------------- | ------------------------ | ------------------------ |
| ![](preview/login.png) | ![](preview/new_quiz.png) | ![](preview/attempt.png) | ![](preview/results.png) |

---

## ⚠️ Known Limitations

-   No Firebase token verification on backend
-   Minimal form validation
-   Quiz IDs are entered manually (no QR/share links)
-   No pagination or admin panel

---

## 🧠 Future Improvements

-   Add Firebase JWT verification in backend
-   Support for image/media-based questions
-   Shareable quiz links
-   Result analytics dashboard

---

## 📄 License

MIT License. Free for personal and academic use.

---

## 🤝 Credits

Made with 💜 by [Raghav Kedia](https://github.com/raghav-kedia)
