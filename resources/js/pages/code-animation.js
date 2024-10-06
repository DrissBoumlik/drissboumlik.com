document.addEventListener('DOMContentLoaded', function () {
    try {
        if (window.innerWidth <= 768) {
            return;
        }
        editor();
        setTimeout(() => {
            reRun();
        }, 2000);
        initCodeEvent();
    } catch (error) {
        // console.log(error);
    }
});

function editor() {
    let aboutCode = document.querySelector('.about-code');
    let ideSections = document.querySelectorAll('.ide-section');
    ideSections.forEach((item, i) => {
        setTimeout(() => {
            item.style.transition = 'transform 0.5s ease';
            item.classList.remove('hidden-small');
        }, i * 250);
    });

    let editorBody = aboutCode.querySelector('.editor-wrapper .body-container');
    editorBody.innerHTML = ''; // empty the editor body
    let colors = ['#48aca2', '#BE8A28', '#5A395A', '#5E5EFB', '#78C078'];
    let limit = 10;
    for (let i = 1; i <= limit; i++) {
        let maxPadding = 5, minPadding = 1;
        let paddingLeft = (i !== 1) ? Math.round(minPadding + Math.random() * (maxPadding - minPadding)) : 0;
        let lineDiv = document.createElement('div');
        lineDiv.id = `line-code-${i}`;
        lineDiv.classList.add('line-code', `line-code-${i}`);
        lineDiv.style.paddingLeft = `${paddingLeft * 10}px`;
        editorBody.appendChild(lineDiv);

        let maxCodeItem = 5, minCodeItem = 2;
        let j = Math.round(minCodeItem + Math.random() * (maxCodeItem - minCodeItem));
        let _colors = [...colors];

        for (let _i = 1; _i <= j; _i++) {
            var color = _colors[Math.floor(Math.random() * _colors.length)];
            let maxWidth = 70, minWidth = 15;
            let width = Math.round(minWidth + Math.random() * (maxWidth - minWidth));
            let span = document.createElement('span');
            span.id = `line-code-${i}-item-${_i}`;
            span.classList.add('line-code-item', `line-code-${i}-item-${_i}`);
            span.style.backgroundColor = color;
            span.style.width = '0px';
            lineDiv.appendChild(span);

            setTimeout(() => {
                span.style.width = `${width}px`;
            }, 100 * (i + _i));

            _colors = _colors.filter(c => c !== color);
        }
    }
}

function reRun(btn = null) {
    document.querySelector('.body-loading').classList.remove('d-none');
    document.querySelector('.about-code .output-wrapper .body-container .lines').classList.add('d-none');
    setTimeout(() => {
        if (btn) btn.disabled = false;
        document.querySelector('.body-loading').classList.add('d-none');
        document.querySelector('.about-code .output-wrapper .body-container .lines').classList.remove('d-none');
        output();
    }, 1000);
    if (btn) {
        btn.classList.remove('pushed');
        btn.disabled = true;
    }
}

function initCodeEvent() {
    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('btn-edit')) {
            let _this = event.target;
            setTimeout(() => {
                _this.disabled = false;
                editor();
            }, 500);
            _this.disabled = true;
        }

        if (event.target.classList.contains('btn-run')) {
            reRun(event.target);
        }
    });
}

function output() {
    let outputBody = document.querySelector('.about-code .output-wrapper .body-container .lines');
    outputBody.innerHTML = ''; // empty the output body
    let limit = 5;
    let _colors = [
        { color: '#C54242', iconClass: 'far fa-times-circle' },
        { color: '#3F8854', iconClass: 'far fa-check-circle' },
        { color: '#3F8854', iconClass: 'far fa-check-circle' },
    ];

    for (let i = 1; i <= limit; i++) {
        var item = _colors[Math.floor(Math.random() * _colors.length)];
        let line = document.createElement('div');
        line.id = `line-output-${i}`;
        line.classList.add('line-output', `line-output-${i}`, 'opacity-0');

        let iconDiv = document.createElement('div');
        iconDiv.classList.add('line-icon');
        let icon = document.createElement('i');
        icon.className = item.iconClass;
        icon.style.color = item.color;
        iconDiv.appendChild(icon);

        let textDiv = document.createElement('div');
        textDiv.classList.add('line-text');
        textDiv.style.backgroundColor = item.color;

        line.appendChild(iconDiv);
        line.appendChild(textDiv);
        outputBody.appendChild(line);

        setTimeout(() => {
            line.classList.add('animate__animated', 'animate__zoomIn');
            line.classList.remove('opacity-0');
        }, 100 * i);
    }
}
