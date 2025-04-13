function initDatetimeLocal() {
  let now = new Date();
  let year = now.getFullYear();
  let month = String(now.getMonth() + 1).padStart(2, '0');
  let day = String(now.getDate()).padStart(2, '0');
  let hours = String(now.getHours()).padStart(2, '0');
  let minutes = String(now.getMinutes()).padStart(2, '0');
  let minDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
  /*document.getElementById("deadline").setAttribute("min", minDateTime);*/
  document.querySelectorAll("input[type='datetime-local']").forEach((input) => {
    input.setAttribute("min", minDateTime);
  });
}
          
document.addEventListener("DOMContentLoaded", function () {
  initDatetimeLocal();
});