// group.js
function createGroup() {
  const nom = document.getElementById("group-name").value.trim();
  const user = localStorage.getItem("github_user");
  if (!nom || !user) return alert("Nom ou utilisateur manquant");

  alert("Groupe '" + nom + "' créé par " + user);
}