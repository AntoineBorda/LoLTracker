import { Moon, Sun } from "lucide-react";
import { useEffect } from "react";
import React = require("react");

const ThemeToggle = () => {
  useEffect(() => {
    const body = document.body;
    const toggleButton = document.getElementById("theme-toggle");

    const handleToggle = () => {
      body.classList.toggle("dark");
      localStorage.setItem(
        "theme",
        body.classList.contains("dark") ? "dark" : "light"
      );
    };

    toggleButton?.addEventListener("click", handleToggle);

    if (localStorage.getItem("theme") === "dark") {
      body.classList.add("dark");
    } else {
      body.classList.remove("dark");
    }

    return () => {
      toggleButton?.removeEventListener("click", handleToggle);
    };
  }, []);

  return (
    <button
      className="inline-flex items-center justify-center px-0 py-2 text-sm font-medium transition-colors rounded-md whitespace-nowrap focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-9 w-9"
      id="theme-toggle"
    >
      <Sun className="h-[1.2rem] w-[1.2rem] rotate-0 scale-100 transition-all dark:-rotate-90 dark:scale-0" />
      <Moon className="absolute w-6 h-6 transition-all scale-0 rotate-90 dark:rotate-0 dark:scale-100" />
      <span className="sr-only">Toggle theme</span>
    </button>
  );
};

export default ThemeToggle;
