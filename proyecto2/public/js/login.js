document.getElementById('togglePassword').addEventListener('click', () => {
  const pwd = document.getElementById('password');
  pwd.type = pwd.type === 'password' ? 'text' : 'password';
});

document.getElementById('loginForm').addEventListener('submit', async (e) => {
  e.preventDefault();

  const username = document.getElementById('username').value;
  const password = document.getElementById('password').value;
  const errorMsg = document.getElementById('errorMsg');
  errorMsg.classList.add('d-none');

  try {
    const response = await fetch('/auth/login', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ username, password })
    });

    if (!response.ok) {
      errorMsg.classList.remove('d-none');
      return;
    }

    const data = await response.json();
    console.log('Login response:', data);
    const token = data.token;

    // Guardar los tokens para realizar las peticiones al servidor
    localStorage.setItem('jwt', token);
    localStorage.setItem('role', data.role);

    // Conseguir el rol desde el payload al decodificar
    const payload = JSON.parse(atob(token.split('.')[1]));
    const role = payload.role;

    // Redirect based on role
    if (data.role === 'ROLE_ADMIN') {
      window.location.href = '/admin/dashboard';
    } else {
      window.location.href = '/user/catalogo';
    }

  } catch (err) {
    errorMsg.classList.remove('d-none');
  }
});

