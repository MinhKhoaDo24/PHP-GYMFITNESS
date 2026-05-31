@extends('pages.auth')

@section('right-panel')
<div class="login-card">
    @if(session()->has('thongbao'))

        @endif
    <div class="logo-container">
        <div class="logo">
            <i class="fa-solid fa-user-plus"></i>
        </div>
        <div class="login-header">
            <h3>Đăng ký tài khoản</h3>
        </div>
    </div>

    @if ($errors->any())
    <div style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);border-radius:10px;padding:12px 16px;margin-bottom:16px;">
        <ul style="margin:0;padding-left:16px;color:#ef4444;font-size:13px;line-height:1.8;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('register') }}" method="POST" class="login-form" id="form-register">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label for="name" class="form-label">Họ và tên</label>
            <div class="input-wrapper">
                <input type="text" name="name" id="name"
                    class="form-control" placeholder="Nguyễn Văn A" required
                    value="{{ old('name') }}">
                <i class="fa-solid fa-user input-icon"></i>
            </div>
            <span class="form-message"></span>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email" class="form-label">Địa chỉ Email</label>
            <div class="input-wrapper">
                <input type="email" name="email" id="email"
                    class="form-control" placeholder="example@email.com" required
                    value="{{ old('email') }}">
                <i class="fa-solid fa-envelope input-icon"></i>
            </div>
            <span class="form-message" id="email-error"></span>
        </div>

        <!-- Address -->
        <div class="form-group">
            <label for="address" class="form-label">Địa chỉ</label>
            <div class="input-wrapper">
                <input type="text" name="address" id="address"
                    class="form-control" placeholder="Số nhà, đường phố, thành phố" required
                    value="{{ old('address') }}">
                <i class="fa-solid fa-map-pin input-icon"></i>
            </div>
            <span class="form-message"></span>
        </div>

        <!-- Phone -->
        <div class="form-group">
            <label for="phone" class="form-label">Số điện thoại</label>
            <div class="input-wrapper">
                <input type="tel" name="phone" id="phone"
                    class="form-control" placeholder="0123456789" required
                    value="{{ old('phone') }}">
                <i class="fa-solid fa-phone input-icon"></i>
            </div>
            <span class="form-message"></span>
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">Mật khẩu</label>
            <div class="input-wrapper">
                <input type="password" name="password" id="password"
                    class="form-control" placeholder="Ít nhất 6 ký tự, đủ mạnh" required>
                <i class="fa-solid fa-lock input-icon"></i>
                <span class="toggle-password" data-target="password">
                    <i class="fa-solid fa-eye"></i>
                </span>
            </div>

            {{-- Strength meter --}}
            <div class="strength-meter" id="strength-meter">
                <div class="strength-bar">
                    <div class="strength-fill" id="strength-fill"></div>
                </div>
                <span class="strength-label" id="strength-label"></span>
            </div>

            {{-- 4 tiêu chí --}}
            <ul class="pwd-rules" id="pwd-rules">
                <li class="rule" id="rule-length">
                    <i class="fa-solid fa-circle-xmark rule-icon"></i>
                    <span>Ít nhất 6 ký tự</span>
                </li>
                <li class="rule" id="rule-upper">
                    <i class="fa-solid fa-circle-xmark rule-icon"></i>
                    <span>Có chữ hoa (A–Z)</span>
                </li>
                <li class="rule" id="rule-lower">
                    <i class="fa-solid fa-circle-xmark rule-icon"></i>
                    <span>Có chữ thường (a–z)</span>
                </li>
                <li class="rule" id="rule-number">
                    <i class="fa-solid fa-circle-xmark rule-icon"></i>
                    <span>Có chữ số (0–9)</span>
                </li>
                <li class="rule" id="rule-symbol">
                    <i class="fa-solid fa-circle-xmark rule-icon"></i>
                    <span>Có ký tự đặc biệt (!@#$%...)</span>
                </li>
            </ul>

            <span class="form-message" id="pwd-message"></span>
        </div>

        <!-- Confirm password -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
            <div class="input-wrapper">
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="form-control" placeholder="Nhập lại mật khẩu" required>
                <i class="fa-solid fa-lock input-icon"></i>
                <span class="toggle-password" data-target="password_confirmation">
                    <i class="fa-solid fa-eye"></i>
                </span>
            </div>
            <span class="form-message" id="confirm-message"></span>
        </div>

        <button type="submit" class="form-submit">
            <span>Đăng ký ngay</span>
        </button>

        <div class="divider">
            <span>Hoặc đăng ký bằng</span>
        </div>

        <div class="social-login">
            <button type="button" class="social-btn">
                <i class="fa-brands fa-google" style="color: #DB4437;"></i> Google
            </button>
            <button type="button" class="social-btn">
                <i class="fa-brands fa-facebook" style="color: #1877F2;"></i> Facebook
            </button>
        </div>

        <div class="auth-links">
            <div class="auth-link">
                Đã có tài khoản? <a href="{{ url('login') }}">Đăng nhập ngay</a>
            </div>
        </div>
    </form>
</div>

<style>
/* ── Strength Meter ───────────────────────────────── */
.strength-meter {
    display: none;
    margin-top: 8px;
    align-items: center;
    gap: 10px;
}
.strength-meter.visible { display: flex; }
.strength-bar {
    flex: 1;
    height: 5px;
    background: rgba(255,255,255,0.1);
    border-radius: 99px;
    overflow: hidden;
}
.strength-fill {
    height: 100%;
    border-radius: 99px;
    width: 0%;
    transition: width 0.4s ease, background 0.4s ease;
}
.strength-label {
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
    min-width: 60px;
    text-align: right;
}

/* ── Password rules list ──────────────────────────── */
.pwd-rules {
    list-style: none;
    padding: 0;
    margin: 10px 0 0;
    display: none;
    flex-direction: column;
    gap: 4px;
}
.pwd-rules.visible { display: flex; }
.rule {
    display: flex;
    align-items: center;
    gap: 7px;
    font-size: 12px;
    color: rgba(255,255,255,0.4);
    transition: color 0.25s;
}
.rule.pass { color: #4ade80; }
.rule.fail { color: rgba(255,255,255,0.35); }
.rule-icon { font-size: 13px; }
.rule.pass .rule-icon { color: #4ade80; }
.rule.pass .rule-icon::before { content: '\f058'; } /* fa-circle-check */
</style>

<script>
/* ═══════════════════════════════════════════════════
   HELPER FUNCTIONS
═══════════════════════════════════════════════════ */
let emailIsValid = true;
let passwordIsValid = false;

function showError(input, message) {
    const formGroup = input.closest('.form-group');
    const errorEl   = formGroup.querySelector('.form-message');
    if (errorEl) errorEl.textContent = message;
    input.classList.add('is-invalid');
    input.classList.remove('is-valid');
}
function showSuccess(input) {
    const formGroup = input.closest('.form-group');
    const errorEl   = formGroup.querySelector('.form-message');
    if (errorEl) errorEl.textContent = '';
    input.classList.remove('is-invalid');
    input.classList.add('is-valid');
}
function hideError(input) {
    const formGroup = input.closest('.form-group');
    const errorEl   = formGroup.querySelector('.form-message');
    if (errorEl) errorEl.textContent = '';
    input.classList.remove('is-invalid', 'is-valid');
}

/* ═══════════════════════════════════════════════════
   PASSWORD STRENGTH CHECKER
═══════════════════════════════════════════════════ */
const pwdInput   = document.getElementById('password');
const meter      = document.getElementById('strength-meter');
const fill       = document.getElementById('strength-fill');
const label      = document.getElementById('strength-label');
const rulesList  = document.getElementById('pwd-rules');

const rules = {
    length : { el: document.getElementById('rule-length'), fn: v => v.length >= 6 },
    upper  : { el: document.getElementById('rule-upper'),  fn: v => /[A-Z]/.test(v) },
    lower  : { el: document.getElementById('rule-lower'),  fn: v => /[a-z]/.test(v) },
    number : { el: document.getElementById('rule-number'), fn: v => /[0-9]/.test(v) },
    symbol : { el: document.getElementById('rule-symbol'), fn: v => /[^A-Za-z0-9]/.test(v) },
};

const strengthConfig = [
    { max: 1, pct: 20,  color: '#ef4444', text: 'Rất yếu' },
    { max: 2, pct: 40,  color: '#f97316', text: 'Yếu'     },
    { max: 3, pct: 60,  color: '#eab308', text: 'Trung bình' },
    { max: 4, pct: 80,  color: '#84cc16', text: 'Mạnh'    },
    { max: 5, pct: 100, color: '#22c55e', text: 'Rất mạnh' },
];

pwdInput.addEventListener('input', function () {
    const val   = this.value;
    let passed  = 0;

    // Cập nhật từng rule
    for (const key in rules) {
        const ok = rules[key].fn(val);
        if (ok) { passed++; rules[key].el.classList.add('pass'); rules[key].el.classList.remove('fail'); }
        else     { rules[key].el.classList.remove('pass'); rules[key].el.classList.add('fail'); }
    }

    if (val.length === 0) {
        meter.classList.remove('visible');
        rulesList.classList.remove('visible');
        passwordIsValid = false;
        hideError(this);
        return;
    }

    meter.classList.add('visible');
    rulesList.classList.add('visible');

    const cfg = strengthConfig.find(c => passed <= c.max) || strengthConfig[4];
    fill.style.width      = cfg.pct + '%';
    fill.style.background = cfg.color;
    label.style.color     = cfg.color;
    label.textContent     = cfg.text;

    // Tất cả 5 tiêu chí đạt → hợp lệ
    passwordIsValid = (passed === 5);
    if (passwordIsValid) showSuccess(this);
    else showError(this, 'Mật khẩu chưa đạt yêu cầu bên dưới.');

    // Realtime check confirm nếu đã nhập
    const confirmInput = document.getElementById('password_confirmation');
    if (confirmInput.value) checkConfirm();
});

/* ═══════════════════════════════════════════════════
   CONFIRM PASSWORD
═══════════════════════════════════════════════════ */
function checkConfirm() {
    const confirmInput = document.getElementById('password_confirmation');
    if (confirmInput.value === '') { hideError(confirmInput); return; }
    if (confirmInput.value !== pwdInput.value) {
        showError(confirmInput, 'Mật khẩu xác nhận không khớp.');
    } else {
        showSuccess(confirmInput);
    }
}
document.getElementById('password_confirmation').addEventListener('input', checkConfirm);

/* ═══════════════════════════════════════════════════
   EMAIL CHECK — kiểm tra email hợp lệ + không trùng
═══════════════════════════════════════════════════ */
const emailInput = document.getElementById('email');

function isEmailFormat(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

// Blur: kiểm tra định dạng rồi AJAX check trùng
emailInput.addEventListener('blur', function () {
    const email = this.value;
    if (!email) { hideError(this); emailIsValid = true; return; }

    if (!isEmailFormat(email)) {
        showError(this, 'Email không đúng định dạng.');
        emailIsValid = false;
        return;
    }

    fetch('{{ route("kiemtra.email") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ email })
    })
    .then(res => res.json())
    .then(data => {
        if (data.exists) {
            showError(this, 'Email này đã được sử dụng. Vui lòng chọn email khác.');
            emailIsValid = false;
        } else {
            showSuccess(this);
            emailIsValid = true;
        }
    })
    .catch(() => { showError(this, 'Không thể kiểm tra email.'); emailIsValid = false; });
});

/* ═══════════════════════════════════════════════════
   REQUIRED FIELDS BLUR
═══════════════════════════════════════════════════ */
['name','address','phone'].forEach(id => {
    const el = document.getElementById(id);
    if (!el) return;
    el.addEventListener('blur', function () {
        if (this.value.trim() === '') showError(this, 'Vui lòng nhập trường này.');
        else showSuccess(this);
    });
    el.addEventListener('input', () => hideError(el));
});

/* ═══════════════════════════════════════════════════
   SUBMIT VALIDATION
═══════════════════════════════════════════════════ */
document.getElementById('form-register').addEventListener('submit', function (e) {
    let formIsValid = true;

    ['name','address','phone'].forEach(id => {
        const el = document.getElementById(id);
        if (el && el.value.trim() === '') {
            showError(el, 'Vui lòng nhập trường này.');
            formIsValid = false;
        }
    });

    if (!emailIsValid) {
        formIsValid = false;
        emailInput.focus();
    }

    if (!passwordIsValid) {
        showError(pwdInput, 'Mật khẩu chưa đạt đủ 5 tiêu chí yêu cầu.');
        formIsValid = false;
    }

    const confirmInput = document.getElementById('password_confirmation');
    if (confirmInput.value !== pwdInput.value) {
        showError(confirmInput, 'Mật khẩu xác nhận không khớp.');
        formIsValid = false;
    }

    if (!formIsValid) e.preventDefault();
});

/* ═══════════════════════════════════════════════════
   TOGGLE PASSWORD VISIBILITY
═══════════════════════════════════════════════════ */
document.querySelectorAll('.toggle-password').forEach(toggle => {
    toggle.addEventListener('click', function () {
        const input = document.getElementById(this.dataset.target);
        const icon  = this.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    });
});
</script>
@endsection

