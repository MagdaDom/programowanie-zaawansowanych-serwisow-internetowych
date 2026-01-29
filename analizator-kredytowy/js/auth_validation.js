//walidacja e-mail
const email = document.querySelector('input[name="email"]'); //document.getElementById('email'); //pobiera wartość email
const hint = document.getElementById('emailHint');

let t = null;
email.addEventListener('input', () => {
    clearTimeout(t);
    t = setTimeout(async () => {
        const v = email.value.trim(); //zapisuje email do zmiennej v
        if (!v) { hint.textContent = ''; return; }
        const fd = new FormData();
        fd.append('email', v);

        if (!email.checkValidity()) {
            hint.textContent = 'Niepoprawny format e-mail.';
            hint.classList.remove('hint-success', 'hint-danger');
            hint.classList.add('hint-danger');
            return;
        }

        //const res = await fetch('check_email.php?email=' + encodeURIComponent(v));
        const res = await fetch('check_email.php', { method: 'POST', body: fd });
        const data = await res.json();
        //const exists = data.exists; //data.ok

        hint.textContent = data.ok ? '' : data.message;
        hint.classList.remove('hint-success', 'hint-danger');
        hint.classList.add(data.ok ? 'hint-danger' : 'hint-success');

    //hint.textContent = exists ? 'Taki e-mail już istnieje' : 'E-mail dostępny';
   // hint.classList.remove('hint-success', 'hint-danger');
    //hint.classList.add(exists ? 'hint-danger' : 'hint-success');
    }, 350); // debounce ~350ms
});

//walidacja hasła
const password = document.querySelector('input[name="password"]');
const passwordHint = document.getElementById('passwordHint');

function passwordStrength(pw) {
    const lenOk = pw.length >= 10;
    const digitOk = /\d/.test(pw);
    const specialOk = /[^A-Za-z0-9]/.test(pw);

    if (!pw) return { level: 'empty', msg: '' };

    if (lenOk && digitOk && specialOk) {
        return { level: 'good', msg: 'Hasło jest bezpieczne.' };
    }

    // warning, ale pozwalamy wysłać
    const missing = [
        !lenOk ? 'minimum 10 znaków' : null,
        !digitOk ? 'cyfry' : null,
        !specialOk ? 'znaki specjalne' : null
    ].filter(Boolean).join(', ');

    return { level: 'weak', msg: `Bezpieczne hasło powinno mieć: ${missing}.` };
}

password.addEventListener('input', () => {
    const r = passwordStrength(password.value);

    passwordHint.classList.remove('hint-success', 'hint-warning');
    if (r.level === 'good') passwordHint.classList.add('hint-success');
    if (r.level === 'weak') passwordHint.classList.add('hint-warning');

    passwordHint.textContent = r.msg;
});
