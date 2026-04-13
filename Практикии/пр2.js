document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contact-form');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(contactForm);
            const data = Object.fromEntries(formData);

            console.log('Данные формы:', data);

            alert('Спасибо! Мы свяжемся с вами в течение 30 минут.');
            contactForm.reset();
        });
    }

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 100,
                    behavior: 'smooth'
                });
            }
        });
    });
});
// Бургер-меню
document.addEventListener('DOMContentLoaded', function() {
    const burgerBtn = document.getElementById('burgerBtn');
    const navMenu = document.getElementById('navMenu');
    const navContacts = document.getElementById('navContacts');
    const navButton = document.querySelector('.nav-button');
    
    if (burgerBtn && navMenu) {
        burgerBtn.addEventListener('click', function() {
            burgerBtn.classList.toggle('active');
            navMenu.classList.toggle('active');
            
            if (navMenu.classList.contains('active')) {

                if (!navMenu.querySelector('.mobile-contacts')) {
                    const mobileContacts = document.createElement('div');
                    mobileContacts.className = 'mobile-contacts';
  
                    const phoneClone = navContacts.cloneNode(true);
                    phoneClone.style.display = 'flex';

                    const buttonClone = navButton.cloneNode(true);
                    buttonClone.style.display = 'block';
                    
                    mobileContacts.appendChild(phoneClone);
                    mobileContacts.appendChild(buttonClone);
                    navMenu.appendChild(mobileContacts);
                }
            }
        });
        
    }
    
});
function showCallBack() {
    let name = prompt("Введите ваше имя:");
    
    if (!name) {
        alert("Пожалуйста, введите ваше имя.");
        return;
    }
    
    let phone = prompt("Введите ваш номер телефона:");
    
    if (!phone) {
        alert("Пожалуйста, введите номер телефона.");
        return;
    }
    
    alert("Спасибо, " + name + "! Мы перезвоним вам на номер " + phone + " в течение 15 минут.");
}
// ===== КВИЗ =====
document.addEventListener('DOMContentLoaded', function() {
    const quizWidget = document.getElementById('quizWidget');
    if (!quizWidget) return;
    
    const steps = quizWidget.querySelectorAll('.quiz-step');
    const nextButtons = quizWidget.querySelectorAll('.quiz-next');
    const prevButtons = quizWidget.querySelectorAll('.quiz-prev');
    const submitButton = quizWidget.querySelector('.quiz-submit');
    const resultBlock = document.querySelector('.quiz-result');
    
    let currentStep = 1;
    const answers = {};
    
    // Включение кнопки "Далее" при выборе ответа
    document.querySelectorAll('.quiz-option input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const step = this.closest('.quiz-step');
            const nextBtn = step.querySelector('.quiz-next');
            if (nextBtn) {
                nextBtn.disabled = false;
            }
            
            const stepNum = step.dataset.step;
            answers[`q${stepNum}`] = this.value;
        });
    });
    
    // Кнопка "Далее"
    nextButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            steps.forEach(step => {
                step.classList.remove('active');
            });
            
            currentStep++;
            const nextStep = quizWidget.querySelector(`[data-step="${currentStep}"]`);
            if (nextStep) {
                nextStep.classList.add('active');
            }
            
            quizWidget.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
    
    // Кнопка "Назад"
    prevButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            steps.forEach(step => {
                step.classList.remove('active');
            });
            
            currentStep--;
            const prevStep = quizWidget.querySelector(`[data-step="${currentStep}"]`);
            if (prevStep) {
                prevStep.classList.add('active');
            }
        });
    });
    
    // Отправка формы
    if (submitButton) {
        submitButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            const name = document.getElementById('quiz-name');
            const phone = document.getElementById('quiz-phone');
            
            if (!name.value || !phone.value) {
                alert('Пожалуйста, заполните имя и телефон');
                return;
            }
            
            const quizData = {
                answers: answers,
                name: name.value,
                phone: phone.value,
                email: document.getElementById('quiz-email').value
            };
            
            console.log('Данные квиза:', quizData);
            
            quizWidget.style.display = 'none';
            if (resultBlock) resultBlock.style.display = 'block';
            
            alert('Спасибо! Мы рассчитаем стоимость и свяжемся с вами');
        });
    }
});
// ===== ПОИСК С ПОДСВЕТКОЙ =====
function searchAndHighlight() {
    let query = document.querySelector('.search-input').value.toLowerCase().trim();
    
    if (query === "") {
        alert("Введите текст для поиска");
        return;
    }
    
    // Очищаем предыдущую подсветку
    removeHighlights();
    
    // Ищем текст на странице
    let found = false;
    let elements = document.querySelectorAll('h1, h2, h3, p, .card-title, .card-text, .service-card, .portfolio-item, button, .btn, .hero-title, .hero-subtitle');
    
    elements.forEach(element => {
        let text = element.textContent.toLowerCase();
        if (text.includes(query)) {
            found = true;
            // Подсвечиваем желтым
            highlightText(element, query);
            // Прокручиваем к первому найденному элементу
            if (!window.scrolledToResult) {
                element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                element.style.transition = 'background 0.5s';
                element.style.background = '#fff3cd';
                setTimeout(() => {
                    element.style.background = '';
                }, 3000);
                window.scrolledToResult = true;
            }
        }
    });
    
    if (!found) {
        alert("Ничего не найдено. Попробуйте другие слова: услуги, разработка, дизайн, блог");
    }
    
    setTimeout(() => {
        window.scrolledToResult = false;
    }, 1000);
}

// Подсветка текста
function highlightText(element, query) {
    let html = element.innerHTML;
    let regex = new RegExp(`(${query})`, 'gi');
    let newHtml = html.replace(regex, `<mark style="background: yellow; color: #000; padding: 0 2px; border-radius: 4px;">$1</mark>`);
    element.innerHTML = newHtml;
}

// Удаление подсветки
function removeHighlights() {
    let marks = document.querySelectorAll('mark');
    marks.forEach(mark => {
        let parent = mark.parentNode;
        parent.innerHTML = parent.innerHTML.replace(/<mark[^>]*>(.*?)<\/mark>/gi, '$1');
    });
}

// Обработчики
document.addEventListener('DOMContentLoaded', function() {
    const searchBtn = document.querySelector('.search-btn');
    const searchInput = document.querySelector('.search-input');
    window.scrolledToResult = false;
    
    if (searchBtn) {
        searchBtn.addEventListener('click', searchAndHighlight);
    }
    
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchAndHighlight();
            }
        });
    }
});