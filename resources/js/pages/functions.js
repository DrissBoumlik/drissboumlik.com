
function generateCode() {
    if (window.innerWidth <= 768) {
        return;
    }
    editor();
    setTimeout(() => {
        reRun();
    }, 2000);
    initCodeEvent();
}

function editor() {
    let aboutCode = $('.about-code');
    $('.ide-section').each(function (i, item){
        setTimeout(() => {
            $(item).css('transition', 'all 0.5s ease').removeClass('hidden-small');
        }, i * 250);
    });
    let editorBody = aboutCode.find('.editor-wrapper .body-container');
    editorBody.empty();
    let colors = ['#48aca2','#BE8A28','#5A395A','#5E5EFB','#78C078'];
    let limit = 10;
    for(let i = 1; i <= limit; i++) {
        let maxPadding = 5, minPadding = 1
        let paddingLeft = (i != 1) ? Math.round(minPadding + Math.random() * (maxPadding -  minPadding)) : 0;
        editorBody.append(`<div id="line-code-${i}" class="line-code line-code-${i}" style="padding-left: ${paddingLeft * 10}px"></div>`);
        let lineCode = editorBody.find(`#line-code-${i}`);
        let maxCodeItem = 5, minCodeItem = 2;
        let j = Math.round(minCodeItem + Math.random() * (maxCodeItem - minCodeItem));
        let _colors = [...colors];
        for (let _i = 1; _i <= j; _i++) {
            var color = _colors[Math.floor(Math.random()*_colors.length)];
            let maxWidth = 70, minWidth = 15;
            let width = Math.round(minWidth + Math.random() * (maxWidth - minWidth));
            lineCode.append(`<span id="line-code-${i}-item-${_i}" class="line-code-item line-code-${i}-item-${_i}" style="background-color:${color}; width:0px"></span>`);
            let lineCodeItem = lineCode.find(`#line-code-${i}-item-${_i}`);
            setTimeout(() => {
                lineCodeItem.css('width', `${width}px`);
            }, 100 * (i + _i));
            _colors = _colors.filter(c => c !== color);
        }

        // setTimeout(() => {
        //     lineCode.removeClass('opacity-0').addClass('animate__animated animate__slideInLeft');
        // }, 100 * i);
    }
}

function reRun(btn = null){
    $('.body-loading').removeClass('d-none');
    $('.about-code .output-wrapper .body-container .lines').addClass('d-none');
    setTimeout(() => {
        if (btn) btn.attr('disabled', false);
        $('.body-loading').addClass('d-none');
        $('.about-code .output-wrapper .body-container .lines').removeClass('d-none');
        output();
    }, 1000);
    if (btn) btn.removeClass('pushed').attr('disabled', true);
}

function initCodeEvent(){
    $(document).on('click', '.btn-edit', function () {
        let _this = $(this);
        setTimeout(() => {
            _this.attr('disabled', false);
            editor();
        }, 500);
        _this.attr('disabled', true);
    });
    $(document).on('click', '.btn-run', function () {
        reRun($(this));
    });
}

function output() {
    let outputBody = $('.about-code .output-wrapper .body-container .lines');
    outputBody.empty();
    let limit = 5;
    let _colors = [{color: '#C54242', iconClass: 'far fa-times-circle'},
        {color: '#3F8854', iconClass: 'far fa-check-circle'},
        // {color: '#F4C009', iconClass: 'fas fa-exclamation-triangle'},
        {color: '#3F8854', iconClass: 'far fa-check-circle'},];
    for (let i = 1; i <= limit; i++) {
        var item = _colors[Math.floor(Math.random() * _colors.length)];
        let line = `<div id="line-output-${i}" class="line-output line-output-${i} opacity-0">
                        <div class="line-icon">
                            <i class="${item.iconClass}" style="color:${item.color}"></i>
                        </div>
                        <div class="line-text" style="background-color:${item.color}"></div>
                    </div>`;
        outputBody.append(line);
        let lineOutput = outputBody.find(`#line-output-${i}`);
        setTimeout(() => {
            lineOutput.addClass('animate__animated animate__zoomIn').removeClass('opacity-0');
        }, 100 * i);
    }
}


function initContactFormEvent () {
    $('#contact-form').on('submit', function(e) {
        e.preventDefault();
        let _this = this;
        let data = $(this).serializeArray();
        data.forEach(function(item, key){
            $(`#error-${item.name}`).remove();
        });

        $('#contact-form-response').remove()
        $(_this).after(`<div id="contact-form-response" class="tc-alert tc-alert-ok text-center"><i class="fa-solid fa-spinner spinClockWise"></i> Sending...</div>`);

        $.ajax({
            method: 'POST',
            url: '/api/get-in-touch',
            data: data,
            success: function (response) {
                $('#contact-form-response').remove()
                $(_this).after(`<div id="contact-form-response" class="tc-alert tc-alert-ok text-center"> ${response.icon} ${response.message}</div>`);
                setTimeout(() => $('#contact-form-response').remove(), 5000);
            },
            error: function (jqXHR, textStatus, errorThrown){
                $('#contact-form-response').remove()
                let errors = jqXHR.responseJSON.errors;
                for(let errorKey in errors) {
                    let messages = errors[errorKey];
                    $(`#form-${errorKey}`).after(`<div id="error-${errorKey}" class="tc-alert tc-alert-error">${messages[0]}</div>`);
                }
            }
        });
    });
}

export { initContactFormEvent, generateCode };
