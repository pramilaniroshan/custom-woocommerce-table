jQuery(document).ready(function($) {
    function updateTotalPrice() {
        let totalPrice = 0;
        $('.product-row').each(function() {
            let quantity = $(this).find('.quantity').val();
            let price = parseFloat($(this).data('price'));
            let subtotal = quantity * price;
            $(this).find('.subtotal').text('$' + subtotal.toFixed(2));
            totalPrice += subtotal;
        });
        $('#total-price').text('Total: $' + totalPrice.toFixed(2));
    }

    // Initial calculation
    updateTotalPrice();

    // Update total price on quantity change
    $('.quantity').on('change keyup', function() {
        updateTotalPrice();
    });

    // Add all products to cart
    $('#add-all-to-cart').on('click', function(e) {
        e.preventDefault();
        let products = [];
        $('.product-row').each(function() {
            let productId = $(this).data('product-id');
            let quantity = $(this).find('.quantity').val();
            if (quantity > 0) {
                products.push({ product_id: productId, quantity: quantity });
            }
        });

        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: {
                action: 'add_multiple_products_to_cart',
                products: products
            },
            success: function(response) {
                if (response.success) {
                    window.location.href = '/cart';
                } else {
                    alert('Failed to add products to cart');
                }
            }
        });
    });
});
