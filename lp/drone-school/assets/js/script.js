window.onload = () => {
    // FAQ各項目クリック時
    const faq = document.querySelectorAll('.faq__list__item');
    faq.forEach(item => {
        item.addEventListener('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            this.classList.toggle('--open');
        });
    });
}

// グローバルナビ固定表示
document.addEventListener("scroll", (event) => {
    if (window.scrollY >= 855) {
        document.querySelector('.header').classList.add('--scrolled');
    } else {
        document.querySelector('.header').classList.remove('--scrolled');
    }
    // document.querySelector('.header').style.top = 0;
});