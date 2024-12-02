/*    Fetch Functions   */ 

async function getPages (){

  const requestOptions = {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
  };
  const response = await fetch("https://alicargo.senet.uz/account/ajax/viho/pochta/pagination.php", requestOptions);
  const responseData = await response.json();
  return responseData.pagesAmount;
}
async function getPageData(pageNumber){
  const tabel = document.querySelector(".table-body");
  const loader = document.querySelector(".loader-box");
  const filter = JSON.parse(localStorage.getItem("filter"));
  let body = undefined;
  if(filter !== null){
    body = `pageNumber=${pageNumber}&filter_action=${filter.action}&filter_option=${filter.option}&method=${filter.method}`
  }else{
    body = `pageNumber=${pageNumber}`;
  }
  tabel.style.display = "none";
  loader.style.display = "block";
  const requestOptions = {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body,
  };
  const response = await fetch("https://alicargo.senet.uz/account/ajax/viho/pochta/page_data.php", requestOptions);
  const responseData = await response.json();  
  tabel.innerHTML = "";
  responseData.forEach((data)=>{
    tabel.appendChild(insertTableData(data));
  });
  loader.style.display = "none";
  tabel.style.display = "";
}

async function sendCart(id){
  const options = {
    method:"POST",
    headers:{
      "Content-Type":'application/x-www-form-urlencoded'
    },
    body:`ID=${id}`
  };
  const response = await fetch("https://alicargo.senet.uz/account/ajax/viho/pochta/add_to_cart.php", options);
  const resData = await response.json();
  return resData;
}

async function searchData(word){
  const options = {
    method:"POST",
    headers:{
      "Content-Type":"application/x-www-form-urlencoded"
    },
    body:`word=${word}`
  };
  const response = await fetch("https://alicargo.senet.uz/account/ajax/viho/pochta/search.php", options);
  const resData = await response.json();
  return resData;
}
/*    Pagination Functions    */ 

function insertTableData(data){
  const tr = document.createElement("tr");
  tr.setAttribute("id", data.ID);
  if(data.CART == "1"){tr.className="bg-secondary";}
  const lastDate = document.createElement("td");
  lastDate.appendChild(document.createTextNode(data.LAST_MODIFIED));
  const id = document.createElement("td");
  id.appendChild(document.createTextNode(data.ID));
  const clientCode = document.createElement("td");
  clientCode.appendChild(document.createTextNode(data.CLIENT_CODE));
  const address = document.createElement("td");
  address.appendChild(document.createTextNode(data.ADRES))
  const phone = document.createElement("td");
  phone.appendChild(document.createTextNode(data.PHONE));
  const weight = document.createElement("td");
  weight.appendChild(document.createTextNode(data.WEIGHT));
  const shelf = document.createElement("td");
  shelf.appendChild(document.createTextNode(data.SHELF));
  const btnTr = document.createElement("td");
  const div = document.createElement("div");
  div.className = "btn-group";
  div.innerHTML = `
  <button class="btn btn-xs btn-outline-primary" onclick="shippedModal(${data.ID})" type="button"><i class="fa fa-truck"></i> </button>
  <button class="btn btn-xs btn-outline-primary" onclick="infoModal(${data.ID})"type="button"><i class="fa fa-file-text"></i> </button>
  <button class="btn btn-xs btn-outline-primary" onclick="addCart(${data.ID})" type="button"><i class="fa fa-plus"></i> </button>`;
  btnTr.appendChild(div);
  tr.insertAdjacentElement("afterbegin",lastDate);
  tr.appendChild(id);
  tr.appendChild(clientCode);
  tr.appendChild(address);
  tr.appendChild(phone);
  tr.appendChild(weight);
  tr.appendChild(shelf);
  tr.appendChild(btnTr);
  return tr;
}

function singlePage(page, active = ""){
  const li = document.createElement("li");
  li.className = "page-item pagination-page "+active;
  const a = document.createElement("a");
  a.className = "page-link";
  a.appendChild(document.createTextNode(page));
  li.insertAdjacentElement("afterbegin", a);
  return li;
}
function prevPage(){
  const li = document.createElement("li");
  li.className = "page-item pagination-prev";
  const a = document.createElement("a");
  a.className = "page-link";
  a.setAttribute("arial-label", "Previous");
  const spanIcon = document.createElement("span");
  spanIcon.setAttribute("aria-hidden", "true");
  spanIcon.innerHTML = "«";
  const spanText = document.createElement("span");
  spanText.className = "sr-only";
  spanText.appendChild(document.createTextNode("Previous"));
  a.insertAdjacentElement("afterbegin", spanText);
  a.insertAdjacentElement("afterbegin", spanIcon);
  li.insertAdjacentElement("afterbegin", a);

  return li;
}
function nextPage(){
  const li = document.createElement("li");
  li.className = "page-item pagination-next";
  const a = document.createElement("a");
  a.className = "page-link";
  a.setAttribute("arial-label", "Next");
  const spanIcon = document.createElement("span");
  spanIcon.setAttribute("aria-hidden", "true");
  spanIcon.innerHTML = "»";
  const spanText = document.createElement("span");
  spanText.className = "sr-only";
  spanText.appendChild(document.createTextNode("Next"));
  a.insertAdjacentElement("afterbegin", spanText);
  a.insertAdjacentElement("afterbegin", spanIcon);
  li.insertAdjacentElement("afterbegin", a);

  return li;
}
function tabelPagination(callback){
  const pagination = document.querySelector(".pagination");
  // let currentPage = +localStorage.getItem("currentPage");
  // if(currentPage == null){
    localStorage.setItem("currentPage", "1");
    currentPage = 1;
  // }

  let pages = getPages();
  
  pages.then(data => {
    pagination.appendChild(prevPage());

    if(data > 5){
      for(let page = 1; 6 >= page; page++){
        if(page == 6){
          pagination.appendChild(singlePage("..."));
          pagination.appendChild(singlePage(data));
        }else if(page == currentPage){
          pagination.appendChild(singlePage(page, "active"));
        }else{
          pagination.appendChild(singlePage(page));
        }
      }
    }else{
      for(let page = 1; data >= page; page++){
        if(page == currentPage){
          pagination.appendChild(singlePage(page, "active"));
        }else{
          pagination.appendChild(singlePage(page));
        }
      }
    }
    
    
    pagination.appendChild(nextPage());
  })
  .then(()=>{callback();});  
}
function updatePagination(number, maxPage, method){
  const pagination = document.querySelector(".pagination");
  if(method == "middel"){
    pagination.innerHTML = "";
    pagination.appendChild(prevPage());
    pagination.appendChild(singlePage(1));
    pagination.appendChild(singlePage("..."));
    pagination.appendChild(singlePage(parseInt(number)-1));
    pagination.appendChild(singlePage(number));
    pagination.appendChild(singlePage(parseInt(number)+1));
    pagination.appendChild(singlePage("..."));
    pagination.appendChild(singlePage(maxPage));
    pagination.appendChild(nextPage());
    pageListener();
  }else if(method == "last"){
    pagination.innerHTML = "";
    pagination.appendChild(prevPage());
    pagination.appendChild(singlePage(1));
    pagination.appendChild(singlePage("..."));
    for(let startPage = maxPage -4; startPage <= maxPage; startPage++){
      pagination.appendChild(singlePage(startPage));
    }
    pagination.appendChild(nextPage());
    pageListener();
  }else if(method == "first"){
    pagination.innerHTML = "";
    if(maxPage > 5){
      pagination.appendChild(prevPage());
      for(let page = 1; 6 >= page; page++){
        if(page == 6){
          pagination.appendChild(singlePage("..."));
          pagination.appendChild(singlePage(maxPage));
        }else{
          pagination.appendChild(singlePage(page));
        }
      }
      pagination.appendChild(nextPage());
    }else{
      pagination.appendChild(prevPage());
      for(let startPage = 1; startPage <= maxPage; startPage++){
        pagination.appendChild(singlePage(startPage));
      }
      pagination.appendChild(nextPage());
    }
    pageListener();
  }
}
function clearUnactive(activeIndex){
  let pageNumbers = document.querySelectorAll(".pagination-page");
  pageNumbers.forEach((item)=>{
    let number = item.querySelector(".page-link").innerText;
    if(number != activeIndex){
      item.classList.remove("active");
    }else{
      item.classList.add("active");
    }
  });
}

function prevFunc(){
  const currentPage = +localStorage.getItem("currentPage");
  let number = currentPage - 1;
  let maxPage = null;
  let method = undefined;
  getPages().then(data=>{
    maxPage = +data;
    if(maxPage > 5 && number <= maxPage-4 && number > 4){
      method = "middel";
    }else if(maxPage > 5 && number <= maxPage && number > maxPage - 4){
      method = "last";
    }else if(number>0 && number < 5){
      method = "first";
    }
    if(currentPage > 1){
      updatePagination(number, maxPage, method);
      localStorage.setItem("currentPage", currentPage-1);
      getPageData(currentPage-1);
      clearUnactive(currentPage-1);
    }
  });

}
function nextFunc(){
  const currentPage = +localStorage.getItem("currentPage");
  let number = currentPage + 1;
  let maxPage = null;
  let method = undefined;
  getPages().then(data=>{
    maxPage = +data;
    if(maxPage > 5 && number <= maxPage-4 && number > 4){
      method = "middel";
    }else if(maxPage > 5 && number <= maxPage && number > maxPage - 4){
      method = "last";
    }else if(number > 0 && number < 5){
      method = "first";
    }
    if(currentPage < maxPage){
      updatePagination(number, maxPage, method);
      getPageData(currentPage+1);
      clearUnactive(currentPage+1);
      localStorage.setItem("currentPage", currentPage+1);
    }
  });

}

function pageListener(){
  let pageNumbers = document.querySelectorAll(".pagination-page");
  let prevPage = document.querySelector(".pagination-prev");
  let nextPage = document.querySelector(".pagination-next");
  let maxPage = null;
  getPages().then(data=>{maxPage = data;})

  prevPage.addEventListener("click", prevFunc);
  nextPage.addEventListener("click", nextFunc);
  pageNumbers.forEach((page, index)=>{
    page.addEventListener("click", function(){
      let number = page.querySelector(".page-link").innerText;

      if(maxPage > 5 && number <= maxPage-4 && number > 4){
        updatePagination(number, maxPage, "middel");
        localStorage.setItem("currentPage", number);
        getPageData(number);
        clearUnactive(number);
      }else if( maxPage > 5 && number <= maxPage && number > maxPage - 4){
        updatePagination(number, maxPage, "last");
        localStorage.setItem("currentPage", number);
        getPageData(number);
        clearUnactive(number);
      }
      else if(maxPage > 5 && number>0 && number < 5){
        updatePagination(number, maxPage, "first");
        localStorage.setItem("currentPage", number);
        getPageData(number);
        clearUnactive(number);
      }else{
        localStorage.setItem("currentPage", number);
        getPageData(number);
        clearUnactive(number);
      }

    });
  });
}

tabelPagination(pageListener);
/*   Pagination End    */ 
function addCart(id){
  const cart = document.querySelector(".cart-count");
  const row = document.getElementById(id);
  sendCart(id).then(data=>{
    if(data.status == "success"){
      row.classList.toggle("bg-secondary");
      cart.innerText = data.cart;
    }
  }).catch(err=>console.log(err));
}

// document.querySelector(".filter-button").addEventListener("click", ()=>{
//   document.querySelector(".filter-options").classList.toggle("d-none");
// });

function filterTabel(e){
  const storageFilter = JSON.parse(localStorage.getItem("filter"));
  const date = document.querySelector(".filter-date");
  const user = document.querySelector(".filter-user");
  const shelf=document.querySelector(".filter-shelf"); 
  if(storageFilter === null){
    localStorage.setItem("filter",`{"action":"conform","option":"date","method":"desc"}`);
    storageFilter = JSON.parse(`{"action":"conform","option":"date","method":"desc"}`);
  }

  let arrowIcon = this.querySelector("i");
  let arrowClass = arrowIcon.classList[1];
  let method = "";
  if(arrowClass == "fa-arrow-down"){
    arrowIcon.classList.remove("fa-arrow-down");
    arrowIcon.classList.add("fa-arrow-up");
    method = "asc";
  }else{
    arrowIcon.classList.add("fa-arrow-down");
    arrowIcon.classList.remove("fa-arrow-up");
    method = "desc";
  }
  let filter = {};
  if(this.classList.contains("filter-date")){

    user.classList.remove("filter-active");
    shelf.classList.remove("filter-active");
    this.classList.add("filter-active");
    filter = {
      action:"conform", 
      option:"date",
      method
    };

  }else if(this.classList.contains("filter-user")){

    date.classList.remove("filter-active");
    shelf.classList.remove("filter-active");
    this.classList.add("filter-active");
    filter = {
      action:"conform",
      option:"client_code",
      method
    };

  }else if(this.classList.contains("filter-shelf")){

    user.classList.remove("filter-active");
    date.classList.remove("filter-active");
    this.classList.add("filter-active");
    filter = {
      action:"conform", 
      option:"shelf",
      method
    };

  }
  const filterJson = JSON.stringify(filter);
  localStorage.setItem("filter", filterJson);
  getPages().then(data=>{
    updatePagination(1, data, "first");
    localStorage.setItem("currentPage", 1);
    clearUnactive(1);
    getPageData(1);
  });

}
function search(e){
  const tabel = document.querySelector(".table-body");
  const filterBtn = document.querySelectorAll(".filter-btn");
  const word = document.querySelector("#search").value;
  const ul = document.querySelector(".pagination");
  const currentPage = localStorage.getItem("currentPage");
  const wordWithoutSpace = word.replace(/^\s+/,""); 
  if(wordWithoutSpace.length == 0){
    getPageData(currentPage);
    ul.classList.remove("d-none");
    filterBtn.forEach(item => item.classList.remove("d-none"));
  }else if(e.keyCode === 13 || this.classList.contains("searchData")){
    searchData(wordWithoutSpace).then(data=>{
      if(data != "empty"){
        tabel.style.display = "none";
        ul.classList.add("d-none");
        filterBtn.forEach(item => item.classList.add("d-none"));
        tabel.innerHTML = "";
        data.forEach((item)=>{
          tabel.appendChild(insertTableData(item));
        });
        tabel.style.display = "";
      }else{
        ul.classList.add("d-none");
        tabel.innerHTML = `<tr></tr>
        <td></td>
        <td></td>
        <td></td>
        <td>Topilmadi</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        </tr>`;
      }
    }).catch(err =>{
      console.log(err);
    });
  }
}

document.querySelector(".filter-date").addEventListener("click", filterTabel);
document.querySelector(".filter-user").addEventListener("click", filterTabel);
document.querySelector(".filter-shelf").addEventListener("click", filterTabel);
document.querySelector("#search").addEventListener("keyup", search);
document.querySelector(".searchData").addEventListener("click", search);