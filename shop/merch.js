// Product prices
const PRODUCT_PRICES = {
    product1: 25.00,   // Space Network T-Shirt
    product2: 20.00,   // Astronaut Baseball Cap
    product3: 8.00,    // Astronaut Ice Cream
    product4: 15.00,   // Solar System Coffee Mug
    product5: 30.00,   // Galaxy Poster Set
    product6: 250.00   // Astronaut Helmet Replica
};

const SHIPPING_COST = 10.00;

// Wait for DOM to load
document.addEventListener('DOMContentLoaded', function() {
    // Get form elements
    const form = document.getElementById('shoppingForm');
    const qty1Input = document.getElementById('qty1');
    const qty2Input = document.getElementById('qty2');
    const qty3Input = document.getElementById('qty3');
    const qty4Input = document.getElementById('qty4');
    const qty5Input = document.getElementById('qty5');
    const qty6Input = document.getElementById('qty6');
    const shippingRadios = document.getElementsByName('shipping');
    
    // Add event listeners for quantity changes
    qty1Input.addEventListener('change', calculateTotals);
    qty2Input.addEventListener('change', calculateTotals);
    qty3Input.addEventListener('change', calculateTotals);
    qty4Input.addEventListener('change', calculateTotals);
    qty5Input.addEventListener('change', calculateTotals);
    qty6Input.addEventListener('change', calculateTotals);
    qty1Input.addEventListener('input', calculateTotals);
    qty2Input.addEventListener('input', calculateTotals);
    qty3Input.addEventListener('input', calculateTotals);
    qty4Input.addEventListener('input', calculateTotals);
    qty5Input.addEventListener('input', calculateTotals);
    qty6Input.addEventListener('input', calculateTotals);
    
    // Add event listeners for shipping method changes
    shippingRadios.forEach(function(radio) {
        radio.addEventListener('change', calculateTotals);
    });
    
    // Add event listener for form submission
    form.addEventListener('submit', function(e) {
        // Validate the form before allowing submission to PHP
        if (!validateForm()) {
            e.preventDefault(); // Prevent submission if validation fails
        }
        // If validation passes, allow normal form submission to shoppingcart.php
    });
    
    // Add event listener for reset button
    form.addEventListener('reset', function() {
        setTimeout(calculateTotals, 0);
        // Clear any invalid field styling
        const inputs = form.querySelectorAll('input');
        inputs.forEach(function(input) {
            input.classList.remove('invalid');
        });
    });
});

// Calculate totals function
function calculateTotals() {
    const qty1 = parseFloat(document.getElementById('qty1').value) || 0;
    const qty2 = parseFloat(document.getElementById('qty2').value) || 0;
    const qty3 = parseFloat(document.getElementById('qty3').value) || 0;
    const qty4 = parseFloat(document.getElementById('qty4').value) || 0;
    const qty5 = parseFloat(document.getElementById('qty5').value) || 0;
    const qty6 = parseFloat(document.getElementById('qty6').value) || 0;
    
    // Calculate subtotals for each product
    const subtotal1 = qty1 * PRODUCT_PRICES.product1;
    const subtotal2 = qty2 * PRODUCT_PRICES.product2;
    const subtotal3 = qty3 * PRODUCT_PRICES.product3;
    const subtotal4 = qty4 * PRODUCT_PRICES.product4;
    const subtotal5 = qty5 * PRODUCT_PRICES.product5;
    const subtotal6 = qty6 * PRODUCT_PRICES.product6;
    
    // Update individual subtotals
    document.getElementById('subtotal1').textContent = subtotal1.toFixed(2);
    document.getElementById('subtotal2').textContent = subtotal2.toFixed(2);
    document.getElementById('subtotal3').textContent = subtotal3.toFixed(2);
    document.getElementById('subtotal4').textContent = subtotal4.toFixed(2);
    document.getElementById('subtotal5').textContent = subtotal5.toFixed(2);
    document.getElementById('subtotal6').textContent = subtotal6.toFixed(2);
    
    // Calculate cart subtotal
    const cartSubtotal = subtotal1 + subtotal2 + subtotal3 + subtotal4 + subtotal5 + subtotal6;
    document.getElementById('cartSubtotal').textContent = cartSubtotal.toFixed(2);
    
    // Get shipping cost
    const shippingMethod = document.querySelector('input[name="shipping"]:checked').value;
    const shippingCost = (shippingMethod === 'shipping') ? SHIPPING_COST : 0;
    document.getElementById('shippingCost').textContent = shippingCost.toFixed(2);
    
    // Calculate grand total
    const grandTotal = cartSubtotal + shippingCost;
    document.getElementById('grandTotal').textContent = grandTotal.toFixed(2);
}

// Validate form function
function validateForm() {
    const form = document.forms['shoppingForm'];
    
    // Clear previous invalid styling
    const inputs = form.querySelectorAll('input');
    inputs.forEach(function(input) {
        input.classList.remove('invalid');
    });
    
    // Get form values
    const customerName = form.elements['customerName'].value.trim();
    const email = form.elements['email'].value.trim();
    const address = form.elements['address'].value.trim();
    const phone = form.elements['phone'].value.trim();
    const zipCode = form.elements['zipCode'].value.trim();
    const creditCard = form.elements['creditCard'].value.trim();
    const qty1 = parseFloat(form.elements['qty1'].value) || 0;
    const qty2 = parseFloat(form.elements['qty2'].value) || 0;
    const qty3 = parseFloat(form.elements['qty3'].value) || 0;
    const qty4 = parseFloat(form.elements['qty4'].value) || 0;
    const qty5 = parseFloat(form.elements['qty5'].value) || 0;
    const qty6 = parseFloat(form.elements['qty6'].value) || 0;
    
    // Validation checks
    if (!customerName) {
        showValidationError(form.elements['customerName'], 'Please enter your name');
        return false;
    }
    
    if (!email) {
        showValidationError(form.elements['email'], 'Please enter your email address');
        return false;
    }
    
    // Basic email validation
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        showValidationError(form.elements['email'], 'Please enter a valid email address');
        return false;
    }
    
    if (!address) {
        showValidationError(form.elements['address'], 'Please enter your address');
        return false;
    }
    
    if (!phone) {
        showValidationError(form.elements['phone'], 'Please enter your phone number');
        return false;
    }
    
    if (!zipCode) {
        showValidationError(form.elements['zipCode'], 'Please enter your ZIP code');
        return false;
    }
    
    // ZIP code validation (exactly 5 digits)
    const zipPattern = /^\d{5}$/;
    if (!zipPattern.test(zipCode)) {
        showValidationError(form.elements['zipCode'], 'ZIP code must be exactly 5 digits');
        return false;
    }
    
    if (!creditCard) {
        showValidationError(form.elements['creditCard'], 'Please enter your credit card number');
        return false;
    }
    
    // Credit card validation (basic check for digits)
    if (!/^\d+$/.test(creditCard)) {
        showValidationError(form.elements['creditCard'], 'Credit card must contain only numbers');
        return false;
    }
    
    // Check if at least one item is ordered
    if (qty1 === 0 && qty2 === 0 && qty3 === 0 && qty4 === 0 && qty5 === 0 && qty6 === 0) {
        alert('Please order at least one item');
        return false;
    }
    
    // All validations passed
    return true;
}

// Show validation error
function showValidationError(element, message) {
    alert(message);
    element.classList.add('invalid');
    element.focus();
    element.select();
}