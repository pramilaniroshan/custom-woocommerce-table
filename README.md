# Custom WooCommerce Product Table Plugin

## Description
The Custom WooCommerce Product Table plugin allows you to display WooCommerce products in a table format with real-time price updates and a single add-to-cart button that adds all selected products to the cart. This is especially useful for wholesale or bulk ordering scenarios.

## Features
- Display products in a specified category in a table format.
- Real-time subtotal and total price updates as quantities are changed.
- Add multiple products to the cart with a single click.
- Responsive and user-friendly design.

## Installation
1. **Download the Plugin:**
   - Clone or download the plugin files from the repository.

2. **Upload to WordPress:**
   - Upload the plugin folder to the `/wp-content/plugins/` directory.

3. **Activate the Plugin:**
   - Go to the WordPress admin dashboard.
   - Navigate to Plugins > Installed Plugins.
   - Find "Custom WooCommerce Product Table" in the list and click "Activate".

## Usage
1. **Add Shortcode to a Page:**
   - Use the `[custom_product_table category="your-category-slug"]` shortcode on any page or post where you want to display the product table.
   - Replace `your-category-slug` with the actual slug of the WooCommerce product category you want to display.

2. **Example Shortcode:**
   ```shortcode
   [custom_product_table category="delica-lancets"]
