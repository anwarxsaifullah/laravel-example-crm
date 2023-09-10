"use strict";
Array.from(document.getElementsByClassName("dropdown")).forEach(function (e) {
  e.addEventListener("click", function (e) {
    var t;
    e.currentTarget.classList.contains("navbar-item")
      ? e.currentTarget.classList.toggle("active")
      : ((t = e.currentTarget.getElementsByClassName("mdi")[1]),
        e.currentTarget.parentNode.classList.toggle("active"),
        t.classList.toggle("mdi-plus"),
        t.classList.toggle("mdi-minus"));
  });
}),
  Array.from(document.getElementsByClassName("mobile-aside-button")).forEach(
    function (e) {
      e.addEventListener("click", function (e) {
        e = e.currentTarget
          .getElementsByClassName("icon")[0]
          .getElementsByClassName("mdi")[0];
        document.documentElement.classList.toggle("aside-mobile-expanded"),
          e.classList.toggle("mdi-forwardburger"),
          e.classList.toggle("mdi-backburger");
      });
    }
  ),
  Array.from(
    document.getElementsByClassName("--jb-navbar-menu-toggle")
  ).forEach(function (e) {
    e.addEventListener("click", function (e) {
      var t = e.currentTarget
        .getElementsByClassName("icon")[0]
        .getElementsByClassName("mdi")[0];
      document
        .getElementById(e.currentTarget.getAttribute("data-target"))
        .classList.toggle("active"),
        t.classList.toggle("mdi-dots-vertical"),
        t.classList.toggle("mdi-close");
    });
  }),
  Array.from(document.getElementsByClassName("--jb-modal")).forEach(function (
    e
  ) {
    e.addEventListener("click", function (e) {
      e = e.currentTarget.getAttribute("data-target");
      document.getElementById(e).classList.add("active"),
        document.documentElement.classList.add("clipped");
    });
  }),
  Array.from(document.getElementsByClassName("--jb-modal-close")).forEach(
    function (e) {
      e.addEventListener("click", function (e) {
        e.preventDefault();
        e.currentTarget.closest(".modal").classList.remove("active"),
          document.documentElement.classList.remove("clipped");
      });
    }
  ),
  Array.from(
    document.getElementsByClassName("--jb-notification-dismiss")
  ).forEach(function (e) {
    e.addEventListener("click", function (e) {
      e.currentTarget.closest(".notification").classList.add("hidden");
    });
  });

// delete confirmation
document.querySelectorAll(".delete").forEach((delButton) => {
  delButton.addEventListener("click", function (e) {
    const delConfirm = document.querySelector("#delete-modal p");
    delConfirm.innerText = `Delete ${e.target.getAttribute(
      "data-item"
    )} ?`;
    const delForm = document.querySelector("#delete-modal form");
    const delFormAction = delForm.getAttribute("action");
    delForm.setAttribute(
      "action",
      delFormAction.replace(/\d+$/, e.target.getAttribute("data-id"))
    );
  });
});

// Edit company form
const companies = document.querySelector('#companies');
if(null !== companies){
  const company = companies.querySelector("#company");
  const web = companies.querySelector("#website");
  const email = companies.querySelector("#email");
  const logo = companies.querySelector('#logo');

  companies.querySelectorAll(".edit").forEach((editButton) => {
    editButton.addEventListener("click", function (e) {
      company.value = e.target.getAttribute("data-company");
      web.value = e.target.getAttribute("data-website");
      email.value = e.target.getAttribute("data-email");

      processImagePreview('edit-modal', e.target.getAttribute('data-img'));

      const editForm = companies.querySelector("#edit-modal form");
      const editFormAction = editForm.getAttribute("action");
      editForm.setAttribute(
        "action",
        editFormAction.replace(/\d+$/, e.target.getAttribute("data-id"))
      );
      companies.querySelector("#edit-modal p.modal-card-title").innerText = e.target.getAttribute("data-title");
      companies.querySelector('#company').focus()
      companies.querySelector('#logo').removeAttribute('required')
      companies.querySelector('#edit-modal form').setAttribute('action', e.target.getAttribute('data-action'))
    });
  });
}

// Edit employee form
const employees = document.querySelector('#employees');
if(null !== employees){
  console.log('fhdfhd')
  const firstName = employees.querySelector("#first_name");
  const lastName = employees.querySelector("#last_name");
  // const compan = employees.querySelector("#compan");
  const eemail = employees.querySelector("#email");
  const phone = employees.querySelector("#phone");


  employees.querySelectorAll(".edit").forEach((editButton) => {
    editButton.addEventListener("click", function (e) {
      console.log(e.target.getAttribute("data-firstname"))
      firstName.value = e.target.getAttribute("data-firstname");
      lastName.value = e.target.getAttribute("data-lastname");
      eemail.value = e.target.getAttribute("data-email");
      phone.value = e.target.getAttribute("data-phone");

      // fill the company select
      const company = employees.querySelector('#company_id option[value="' + e.target.getAttribute("data-companyid") + '"]');
      if(company){
        company.selected = true;
      }

      const editForm = employees.querySelector("#edit-modal form");
      const editFormAction = editForm.getAttribute("action");
      editForm.setAttribute(
        "action",
        editFormAction.replace(/\d+$/, e.target.getAttribute("data-id"))
      );
      employees.querySelector('#first_name').focus()
    });
  });
}
// Add button
const addButton = document.querySelector(".add.button");
if(null !== addButton){
  addButton.addEventListener("click", function (e) {
    e.preventDefault();
    (document.querySelector('#add-modal #company') || document.querySelector('#add-modal #first_name')).focus();
  });
}


function processImagePreview(modalId, imageUrl){
  const imgWrapper = document.getElementById(modalId).getElementsByClassName('image')[0];
  const img = document.createElement('img');

  if(imgWrapper.contains(imgWrapper.getElementsByTagName('img')[0])){
    imgWrapper.removeChild(imgWrapper.getElementsByTagName('img')[0]);
  }

  img.src = imageUrl;
  imgWrapper.appendChild(img);
  imgWrapper.classList.remove('hidden');
  imgWrapper.classList.add('flex');
  imgWrapper.classList.add('items-center');
}

// Image preview
function showImagePreview(e) {
  const imageUrl = URL.createObjectURL(e.target.files[0]);
  const modalId = (e.target.getAttribute('data-modal') === 'add') ? 'add-modal' : 'edit-modal';
  processImagePreview(modalId, imageUrl);
}


// Hide login help
function hideHelp(e){
  // Get the parent element
  const parent = e.target.parentElement.parentElement;

  // Find the help element within the parent
  const helpText = parent.querySelector('.help');
  // Hide the help element by setting its style to 'display:none'
  if(helpText){
    if(e.target.value !== ''){
      helpText.classList.add('hidden')
    } else{
      helpText.classList.remove('hidden');
    }
  }
}