"use client";

import { useState, FormEvent } from "react";

export default function Home() {
  const [password, setPassword] = useState("");
  const [isAuthenticated, setIsAuthenticated] = useState(false);
  const [notes, setNotes] = useState("");
  const [error, setError] = useState("");

  const handleLogin = async (e: FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    if (password === atob("VGgwcm4zX1MzY3VyM19QQHN3")) {
      setIsAuthenticated(true);
      try {
        const response = await fetch(`/api/${btoa("notes")}`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ password }),
        });

        const data = await response.json();
        if (data.success) {
          setNotes(data.notes);
        } else {
          setError("Failed to fetch notes.");
        }
      } catch (err) {
        setError("Something went wrong.");
      }
    } else {
      setError("Invalid password. Try again.");
    }
  };

  return (
    <div className="font-sans min-h-screen p-8 bg-gray-100 dark:bg-gray-900">
      <header className="mb-8 text-center">
        <h1 className="text-3xl font-bold mb-2">
          Thorne&apos;s Digital Notebook
        </h1>
        <p className="text-gray-600 dark:text-gray-400">
          Personal thoughts and records
        </p>
      </header>

      <main className="max-w-2xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        {!isAuthenticated ? (
          <div className="login-container">
            <h2 className="text-xl font-semibold mb-4">Password Required</h2>
            <p className="mb-4 text-gray-600 dark:text-gray-400">
              This notebook is private. Please enter the password to continue.
            </p>

            <form onSubmit={handleLogin} className="space-y-4">
              <div>
                <label
                  htmlFor="password"
                  className="block mb-1 text-sm font-medium"
                >
                  Password
                </label>
                <input
                  type="password"
                  id="password"
                  value={password}
                  onChange={(e) => setPassword(e.target.value)}
                  className="w-full p-2 border rounded-md"
                  required
                />
              </div>

              {error && <p className="text-red-500 text-sm">{error}</p>}

              <button
                type="submit"
                className="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md"
              >
                Access Notebook
              </button>
            </form>
          </div>
        ) : (
          <div className="notes-container">
            <h2 className="text-xl font-semibold mb-4">My Personal Notes</h2>
            <div className="notes-content whitespace-pre-wrap bg-gray-50 dark:bg-gray-700 p-4 rounded-md">
              {"Unauthorized access: IP did not match"}
            </div>
          </div>
        )}
      </main>

      <footer className="mt-8 text-center text-gray-600 dark:text-gray-400 text-sm">
        <p>© 2212 Thorne&apos;s Private Notebook</p>
      </footer>
    </div>
  );
}
