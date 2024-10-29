import hljs from 'highlight.js';
import 'highlight.js/styles/default.css';
import 'highlight.js/styles/atom-one-dark.css';
import { capitalize } from 'lodash';

document.addEventListener('DOMContentLoaded', function () {
    try {
        let searchBlogFormWrapper = document.querySelector('.search-blog-form-wrapper');
        let searchBlogInput = document.querySelector('.search-blog-input');
        let displaySearchFormBtn = document.querySelector('.display-search-form');

        if (searchBlogFormWrapper) {
            window.addEventListener('keydown', function (event) {
                if (event.ctrlKey && (event.key === 'k' || event.key === 'K')) {
                    event.preventDefault();
                    searchBlogFormWrapper.classList.remove('d-none');
                    searchBlogFormWrapper.classList.add('show');
                    if (searchBlogInput) {
                        searchBlogInput.focus();
                    }
                }
            });

            searchBlogFormWrapper.addEventListener('click', function (event) {
                if (event.target === searchBlogFormWrapper) {
                    searchBlogFormWrapper.classList.add('d-none');
                }
            });

            if (displaySearchFormBtn) {
                displaySearchFormBtn.addEventListener('click', function () {
                    searchBlogFormWrapper.classList.remove('d-none');
                    searchBlogFormWrapper.classList.add('show');
                    if (searchBlogInput) {
                        searchBlogInput.focus();
                    }
                });
            }
        }

        hljs.highlightAll();

        // Select all <pre> elements
        const preTags = document.querySelectorAll("pre");
		preTags.forEach(preTag => {

			// Get the class from the <pre> tag, e.g., "language-powershell"
			let languageClass = Array.from(preTag.classList).find(c => c.startsWith("language-")) || "language-unknown";
			languageClass = languageClass.replace('language-', '');
			languageClass = capitalize(languageClass);

			// Create the container div
			const containerDiv = document.createElement("div");
			containerDiv.className = "code-data";

			// Create the copy button
			const copyButton = document.createElement("span");
			copyButton.classList.add("btn-copy");
			copyButton.innerText = "Copy";

			// Add click event to copy the code content
			copyButton.addEventListener("click", () => {
				const codeText = preTag.querySelector("code").innerText;
				navigator.clipboard.writeText(codeText).then(() => {
					copyButton.innerText = "Copied!";
					setTimeout(() => (copyButton.innerText = "Copy"), 1500);
				});
			});

			// Create the span for the language class
			const languageSpan = document.createElement("span");
			languageSpan.classList.add("code-language");
			languageSpan.innerText = languageClass;

			// Append button and span to the container div
			containerDiv.appendChild(languageSpan);
			containerDiv.appendChild(copyButton);

			// Insert the container div into the <pre> element
			preTag.appendChild(containerDiv);

		});

        setTimeout(() => {
            preTags.forEach(preTag => {
                preTag.classList.remove("loading-spinner")
            });
        }, 500);

    } catch (error) {
        console.log(error);
    }
});
