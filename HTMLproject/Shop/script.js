function getProducts() {
  const products = localStorage.getItem('products');
  return products ? JSON.parse(products) : [];
}


function displayProducts() {
  const products = getProducts();
  const productsgrid = document.getElementById("products-grid");
  for (let i = 0; i < products.length; i++) {
      let productcard;
      productcard = document.createElement('div');
      productcard.className = 'product-card';
      document.querySelector('#products-grid').appendChild(productcard);
      productcard.innerHTML += `
                    <img src="${products[i].image}" alt="Product" class="product-img">
                    <p class="product-name">${products[i].name}</p>
                    <p class="product-price">${products[i].price} Ar</p>
                    <div id="buttons">
                      <button class="product-button" onclick="buy(event)">Buy Now</button>
                      <button class="redeem-button">Redeem</button>
                    </div>`;
  }
}

displayMoney();
displayProducts();

function getMoney() {
  let money = localStorage.getItem('money');
  if (money === null) {
     money = {
         budget: 0,
         expenses: 0
     };
     return money
  } else {
    // money is found in local storage
    return JSON.parse(money);
  }
}

function storeMoney(money) {
    money = {
        budget: parseFloat(money.budget),
        expenses: parseFloat(money.expenses)
    };
    localStorage.setItem('money', JSON.stringify(money));
}

function displayMoney() {
     document.querySelector('#monitor').innerHTML = ` 
          <p>Budget:</p>         
          <div id="budget">
               <p id="budget">${getMoney().budget}</p>
          </div>
           <p>Expenses:</p>
          <div id="expenses">
               <p id="expenses">${getMoney().expenses}</p>
          </div>`;    
}


function buy(event) {
  clickedProduct = event.target;
  var product = clickedProduct.closest('.product-card');
  var productName = product.querySelector('.product-name').textContent;
  var productPrice = product.querySelector('.product-price').textContent;
  var products = getProducts();
  // loop through the products array and find the matching product
  for (var i = 0; i < products.length; i++) {
      if (products[i].name == productName && products[i].price == parseFloat(productPrice)) {
          let money = getMoney();
          if (money.budget - products[i].price < 0) {
               alert("Add money to your budget");
          } else {
             money.budget -= products[i].price;
             money.expenses += products[i].price;
             storeMoney(money);
             displayMoney();
            }
          break;
        }
   }
}

function search(query) {
      var results = [];
      let products = getProducts();
      for (var i = 0; i < products.length; i++) {
           var item = products[i].name.toLowerCase();
           var item1 = String(products[i].price);
           var query = query.toLowerCase();
           if (item.includes(query) || item1.includes(query)) {
               results.push(products[i]);
           }
        }
       return results;
}

function displayResults(results) {
       var resultDiv = document.getElementById("result-div");
       if (resultDiv.style.display == "none") {
            resultDiv.style.display = "block";
       }
       resultDiv.innerHTML = "";
       if (results.length > 0) {
           for (var i = 0; i < results.length; i++) {
                var resultPara = document.createElement("p");
                resultDiv.appendChild(resultPara);
                resultPara.textContent = results[i].name + ": " + results[i].price;
            }
        } else {
                 var noResultPara = document.createElement("p");
                 noResultPara.textContent = "No results found";
                 resultDiv.appendChild(noResultPara);
              }
}

var searchBar = document.getElementById("search-box");
var searchButton = document.getElementById("search-button");

searchBar.addEventListener("input", function() {
  // Get the user input from the input element
  var query = searchBar.value;
  // Perform a search operation using the user input
  var results = search(query);
  // Display the results on the web page
   displayResults(results);
});

// Add an event listener to the button element to detect when the user clicks on it
searchButton.addEventListener("click", function() {
  // Get the user input from the input element
  var query = searchBar.value;
  // Perform a search operation using the user input
  var results = search(query);
  // Display the results on the web page
  displayResults(results);
});

window.onclick = function(event) {
      if (!(event.target.matches('#search-box') || event.target.matches('#search-button'))) {
        var dropdowns = document.getElementById("result-div");
        if (dropdowns.style.display != "none") {
            dropdowns.style.display = "none";
        }
      }
}