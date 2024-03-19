function storeMoney(money) {
    money = {
        budget: parseFloat(money.budget),
        expenses: parseFloat(money.expenses)
    };
    localStorage.setItem('money', JSON.stringify(money));
}

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

// function to store products in localStorage
function storeProducts(products) {
  // convert product prices to floating-point numbers
  const newproduct = products.map( product => ({
                             ...product,
                             price: parseFloat(product.price)
                             })
                   );
  localStorage.setItem('products', JSON.stringify(newproduct));
  //JJLC.setItem(‘products’, newproduct);
}

// function to retrieve products from localStorage
function getProducts() {
  const products = localStorage.getItem('products');
  //const products = JJLC.getItem(‘products’); 
  //return products ? products : [];
  return products ? JSON.parse(products) : [];
}

// function to display products on the page
function displayProducts() {
  
  const addButton = document.createElement('div');
  addButton.className = 'add-product';
  document.querySelector('#container').appendChild(addButton);
  addButton.innerHTML = `
                <img src="add-icon.png" alt="add-icon">`
  let products = getProducts();
  for (let i = 1; i<= products.length; i++) {
     let newProduct = document.createElement('div');
     newProduct.className = 'product';
     document.querySelector('#container').appendChild(newProduct); 
     newProduct.innerHTML += `
           <img src="${products[i-1].image}" alt= "produit" onclick="changeImage(event)" class="product-img">
           <div class="product-info">
                    <p>${products[i-1].name}</p>
                    <p>${products[i-1].price}</p>
           </div>
           <!-- Create a container element for the dropdown -->
           <div class="dropdown">
                <!-- Create a button element for the dropdown button -->
                <div class="dropbtn" onclick="showDropdown(this)"><img src="More2.png"></div>
                <!-- Create another container element for the dropdown content -->
                    <div class="dropdown-content" style="display: none">
                    <!-- Create a list element for the dropdown items -->
                        <!-- Create list item elements for each dropdown item -->
                        <ul class="dropdown-menu">
                        <!-- Create list item elements for each dropdown item -->
                           <li><a href="#" class = "modify-link">Modify</a></li>
                           <li><a href="#" class="delete-link">Delete</a></li>
                       </ul>
                    </div>
           </div>`; 
  }
}

// display stored products when the page is loaded
displayProducts();

document.querySelector('#icons').addEventListener('click', function(e) {
   if (e.target.closest('#budget-container')) {
     e.preventDefault();
     var budget = e.target.closest('#budget-container');
     var money = getMoney();
     newbudget = parseFloat(prompt('Add money your budget:'));
     }
     if (newbudget) {
     money.budget += newbudget;
     storeMoney(money);
     budget.remove();
     document.querySelector('#icons').innerHTML = '';
     displayMoney();
     }
   }
);

// add a click event listener to the container element
document.querySelector('#container').addEventListener('click', function(e) {
  // check if the event target is an add-product element
  if (e.target.closest('.add-product')) {
    var productName = prompt('Enter the product name:').substring(0, 17);// limit to 10 by slicing the character using .substring
    var productPrice = parseFloat(prompt('Enter the product price:').substring(0, 17));// limit to 10 by slicing the character

    if (productName && productPrice) { 
      const products = getProducts();
      let existAlready = false;
      for (var i = 0; i < products.length; i++) {
           if (products[i].name == productName && products[i].price == productPrice) {
               existAlready = true;
               alert("Product already in the database!");
               break;
            }
      }
      if (! existAlready) {
           products.push({ image: "file:///C:/Users/Lalaina/HTMLproject/ShoppingInput/product.jpg", name: productName, price: productPrice });
           storeProducts(products);
           // clear container and re-display products
           document.querySelector('#container').innerHTML = '';
           displayProducts();
      }
    }
  }

  // check if the event target is a delete-link element
  if (e.target.closest('.delete-link')) {
    // prevent default behavior of reloading the page
    e.preventDefault();
    // get the product element that contains the clicked link
    var product = e.target.closest('.product');
    // get the product name and price from the product element
    var productName = product.querySelector('.product-info p:first-child').textContent;
    var productPrice = product.querySelector('.product-info p:last-child').textContent;
    // get the products array from localStorage
    var products = getProducts();
    // loop through the products array and find the matching product
    for (var i = 0; i < products.length; i++) {
      if (products[i].name == productName && products[i].price == productPrice) {
        // remove the product from localStorage
        localStorage.removeItem(products[i]);
        // remove the product from the array
        products.splice(i, 1);
        // break out of the loop
        break;
      }
    }
    // store the updated products array in localStorage
    storeProducts(products);
    // remove the product element from the page
    product.remove();
    // clear container and re-display products
    document.querySelector('.container').innerHTML = '';
    displayProducts();
  }

   // check if the event target is a modify-link element
   if (e.target.closest('.modify-link')) {
     // prevent default behavior of reloading the page
     e.preventDefault();
     // get the product element that contains the clicked link
     var product = e.target.closest('.product');
     // get the product name and price from the product element
     var productName = product.querySelector('.product-info p:first-child').textContent;
     var productPrice = product.querySelector('.product-info p:last-child').textContent;
     // get the products array from localStorage
     var products = getProducts();
     // loop through the products array and find the matching product
     for (var i = 0; i < products.length; i++) {
       if (products[i].name == productName && products[i].price == productPrice) {
         let temp1 = prompt('Enter the product name:').substring(0, 17);
         let temp2 = parseFloat(prompt('Enter the product price:').substring(0, 17));
         if (temp1) { 
             products[i].name = temp1;
         }
         if (temp2) { 
             products[i].price = temp2;
         }
         break;
       }
     }
     // store the updated products array in localStorage
     storeProducts(products);
     // remove the product element from the page
     product.remove();
     // clear container and re-display products
     document.querySelector('#container').innerHTML = '';
     displayProducts();
   }
});

function showDropdown(icon) {
  // get the sibling element with class name 'dropdown-content'
  var content = icon.nextElementSibling;
  // check if the content is hidden or not
  if (content.style.display == "none") {
    // if hidden, show it
    content.style.display = "block";
    // get the position of the icon relative to the viewport
    var rect = icon.getBoundingClientRect();
    // set the top and left style of the content to match the icon position
    // adjust for scroll position and desired offset
    content.style.top = (rect.top + window.scrollY - -17) + "px";
    content.style.left = (rect.left + window.scrollX - 50) + "px";
  } else {
    // if not hidden, hide it
    content.style.display = "none";
  }
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
      if (!event.target.matches('.dropbtn')) {
        // get all elements with class name 'dropdown-content'
        var dropdowns = document.getElementsByClassName("dropdown-content");
        // loop through them and hide them
        for (var i = 0; i < dropdowns.length; i++) {
          var openDropdown = dropdowns[i];
          if (openDropdown.style.display == "block") {
            openDropdown.style.display = "none";
         }
      }
   }
}

function displayMoney() {
     document.querySelector('#icons').innerHTML = `          
          <div id="budget-container">
               <img src="budget.png" alt="Budget Icon">
               <p id="budget-value">${getMoney().budget}</p>
          </div>

          <div id="expenses-container">
               <img src="expenses.png" alt="Expenses Icon">
               <p id="expenses-value">${getMoney().expenses}</p>
          </div>`;    
}

displayMoney();

var clickedImage;

// Define the changeImage function
function changeImage(event) {
  // Get a reference to the image element that was clicked and assign it to the global variable

  clickedImage = event.target;

  // Get a reference to the file-input element
  let fileInput = document.getElementById("file-input");

  // Trigger a click event on the file-input element
  fileInput.click();
}

// Define the loadImage function
function loadImage(event) {
  // get the product element that contains the clicked link
  var product = clickedImage.closest('.product');
  // get the product name and price from the product element
  var productName = product.querySelector('.product-info p:first-child').textContent;
  var productPrice = product.querySelector('.product-info p:last-child').textContent;

  // Get a reference to the file-input element that triggered the change event
  let fileInput = event.target;

  // Get an array of files that were selected by the user
  let files = fileInput.files;

  // Check if there is at least one file in the array
  if (files.length > 0) {
    // Get the first file object in the array
    let file = files[0];

    // Create a FileReader object
    let reader = new FileReader();

    // Define a function that will run when the reader finishes loading the file
    reader.onload = function() {
      // Get the data URL that represents the file content
      let dataURL = reader.result;

      // get the products array from localStorage
      var products = getProducts();
      // loop through the products array and find the matching product
      for (var i = 0; i < products.length; i++) {
        if (products[i].name == productName && products[i].price == productPrice) {
          products[i].image = dataURL;
          // store the updated products array in localStorage
          storeProducts(products);
          // clear container and re-display products
          document.querySelector('#container').innerHTML = '';
          displayProducts();
          break;
        }
      }
    };

    // Read the file object as a data URL
    reader.readAsDataURL(file);
    // Reset the value of the file-input element
    fileInput.value = "";
  }
}


// function to remove all items from localStorage
function clearLocalStorage() {
  localStorage.clear();
}







