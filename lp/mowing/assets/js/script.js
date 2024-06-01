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

    // 紹介動画サムネイルクリック時
    const movie_thumb = document.querySelectorAll('.thumb__overlay');
    movie_thumb.forEach(item => {
        item.addEventListener('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            // 強制的に埋め込み動画を再生
            const iframe = item.parentElement.querySelector('.movie');
            const player = iframe.contentWindow;
            player.postMessage('{"event":"command","func":"playVideo","args":""}', "*");
            // サムネイルを非表示
            item.style.display = "none";
            item.parentElement.querySelector('.thumb').style.display = "none";
        });
    });
}