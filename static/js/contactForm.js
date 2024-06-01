$(function() {
    function _getcookie(name) {
        const array = document.cookie.split(';');

        let cookies = [];
        array.forEach(function(value) {
            const content = value.split('=');
            cookies[content[0]] = content[1];
        });

        return cookies[name] ?? null;
    }


    function _validate(data) {
        const { lastname, firstname, company, email, message } = data;

        const validateEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        let errors = [];
        if (!lastname) {
            const message = '姓を入力してください';
            errors.push(message);
        }
        if (!firstname) {
            const message = '姓を入力してください';
            errors.push(message);
        }
        if (!company) {
            const message = '会社名を入力してください';
            errors.push(message);
        }
        if (!email) {
            const message = 'メールアドレスを入力してください';
            errors.push(message);
        }
        if (!validateEmail.test(email)) {
            const message = 'メールアドレスの形式が誤っています';
            errors.push(message);
        }
        if (!message) {
            const message = 'メッセージを入力してください';
            errors.push(message);
        }

        if (errors.length > 0) {
            $('.ContactForm_error').text(errors[0]);
            return false;
        }

        return true;
    }

    
    $('.ContactForm_button').click(function (e) {
        e.preventDefault();
        e.stopPropagation();

        const formData = {
            lastname  : $('input[name="lastname"]').val() ?? "",
            firstname : $('input[name="firstname"]').val() ?? "",
            company   : $('input[name="company"]').val() ?? "",
            email     : $('input[name="email"]').val() ?? "",
            message   : $('textarea[name="message"]').val() ?? "",
        }

        if (!_validate(formData)) {
            return false;
        }

        const HUBSPOT_PORTAL_ID = $('input[name="HUBSPOT_PORTAL_ID"]').val();
        const HUBSPOT_FORM_ID = $('input[name="HUBSPOT_FORM_ID"]').val();

        fetch(
            `https://api.hsforms.com/submissions/v3/integration/submit/${HUBSPOT_PORTAL_ID}/${HUBSPOT_FORM_ID}`,
            {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    context: {
                        hutk: _getcookie('hubspotutk'),
                        pageUri: document.referrer,
                    },
                    fields: [
                        {
                            objectTypeId: '0-1',
                            name: 'lastname',
                            value: formData.lastname,
                        },
                        {
                            objectTypeId: '0-1',
                            name: 'firstname',
                            value: formData.firstname,
                        },
                        {
                            objectTypeId: '0-1',
                            name: 'company',
                            value: formData.company,
                        },
                        {
                            objectTypeId: '0-1',
                            name: 'email',
                            value: formData.email,
                        },
                        {
                            objectTypeId: '0-1',
                            name: 'message',
                            value: formData.message,
                        },
                    ],
                }),
            },
        ).then(function(response) {
            if (!response.ok) {
                console.error(response.status, response.statusText);
                throw new Error(response.statusText);
            }
            $('.ContactForm').addClass('posted');
        });
    });
});