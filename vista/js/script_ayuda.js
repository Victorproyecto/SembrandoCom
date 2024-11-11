
// Script para mostrar y ocultar las respuestas
document.querySelectorAll('.faq-question').forEach((question) => {
    question.addEventListener('click', () => {
        const answer = question.nextElementSibling;
        answer.classList.toggle('visible');
        question.classList.toggle('active');
    });
});