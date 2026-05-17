// adminGuard.js
console.log('token:', localStorage.getItem('jwt'));
console.log('role:', localStorage.getItem('role'));

const token = localStorage.getItem('jwt');
const role = localStorage.getItem('role');

if (!token || role !== 'ROLE_ADMIN') {
  console.log('Redirecting to login — no valid admin session');
  window.location.href = '/';
}

function logout() {
  const token = localStorage.getItem("jwt");

  fetch("/auth/logout", {
    method: "POST",
    headers: {
      "Authorization": "Bearer " + token
    }
  }).finally(() => {
    localStorage.removeItem("jwt");
    localStorage.removeItem("role");
    window.location.href = "/login";
  });
}
