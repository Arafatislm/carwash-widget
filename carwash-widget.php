<?php
/**
 * Plugin Name: CarWash Widget
 Plugin URI: https://github.com/Arafatislm/carwash-widget/
 * Description: A customizable, responsive pricing table for car wash services using Tailwind and FontAwesome. Use shortcode [cw_widget].
 * Version: 1.0
 * Author: Arafat
 * Author URI: https://arafatislam.net
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: carwash-widget
 */

if (!defined('ABSPATH')) {
    exit;
}

class CW_Car_Wash_Widget {

    private $option_name = 'cw_widget_data';

    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_shortcode('cw_widget', array($this, 'render_shortcode'));
        
        // Initialize default data if empty
        if (get_option($this->option_name) === false) {
            update_option($this->option_name, $this->get_default_data());
        }
    }

    /**
     * Default Data based on user snippet
     */
    private function get_default_data() {
        return array(
            'regular' => array(
                'id' => 'regular',
                'name' => 'Regular Size Car',
                'icon' => 'fa-solid fa-car-side',
                'packages' => array(
                    array('title' => 'Exterior Only', 'price' => 25, 'time' => '45min', 'features' => array('100% Hand Wash & Hand Dry', 'Tire & Wheel Clean', 'Tire Dressing', 'Foam Wax', 'Exterior Windows', 'Fast, Quality Refresh')),
                    array('title' => 'Deluxe', 'price' => 35, 'time' => '1h 15min', 'features' => array('Everything in Exterior Only', 'Full Interior Vacuum', 'Floor Mats Vacuum', 'Wipe-down (Dash, Doors, Consoles)', 'Air Freshener')),
                    array('title' => 'Premium', 'price' => 50, 'time' => '1h 30min', 'features' => array('Full Interior + Exterior Wash', 'Rainbow Triple Coat Foam', 'All 4 Rubber/Plastic Mats Cleaned', 'All 4 Cloth Mats Shampooed', 'Leather Seats Dressing', 'Dash & Doors Dressing', 'Door Jambs', 'Trunk Vacuum', 'Air Freshener', 'Double Wheel Clean & Tire Dressing'))
                )
            ),
            'sports' => array(
                'id' => 'sports',
                'name' => 'Sports Car',
                'icon' => 'fa-solid fa-car',
                'packages' => array(
                    array('title' => 'Exterior Only', 'price' => 30, 'time' => '45min', 'features' => array('100% Hand Wash & Hand Dry', 'Tire & Wheel Clean', 'Tire Dressing', 'Foam Wax', 'Exterior Windows', 'Fast, Quality Refresh')),
                    array('title' => 'Deluxe', 'price' => 40, 'time' => '1h 15min', 'features' => array('Everything in Exterior Only', 'Full Interior Vacuum', 'Floor Mats Vacuum', 'Wipe-down (Dash, Doors, Consoles)', 'Air Freshener')),
                    array('title' => 'Premium', 'price' => 55, 'time' => '1h 30min', 'features' => array('Full Interior + Exterior Wash', 'Rainbow Triple Coat Foam', 'All 4 Rubber/Plastic Mats Cleaned', 'All 4 Cloth Mats Shampooed', 'Leather Seats Dressing', 'Dash & Doors Dressing', 'Door Jambs', 'Trunk Vacuum', 'Air Freshener', 'Double Wheel Clean & Tire Dressing'))
                )
            ),
            'suv' => array(
                'id' => 'suv',
                'name' => 'SUV',
                'icon' => 'fa-solid fa-car-rear',
                'packages' => array(
                    array('title' => 'Exterior Only', 'price' => 30, 'time' => '45min', 'features' => array('100% Hand Wash & Hand Dry', 'Tire & Wheel Clean', 'Tire Dressing', 'Foam Wax', 'Exterior Windows', 'Fast, Quality Refresh')),
                    array('title' => 'Deluxe', 'price' => 40, 'time' => '1h 15min', 'features' => array('Everything in Exterior Only', 'Full Interior Vacuum', 'Floor Mats Vacuum', 'Wipe-down (Dash, Doors, Consoles)', 'Air Freshener')),
                    array('title' => 'Premium', 'price' => 55, 'time' => '1h 30min', 'features' => array('Full Interior + Exterior Wash', 'Rainbow Triple Coat Foam', 'All 4 Rubber/Plastic Mats Cleaned', 'All 4 Cloth Mats Shampooed', 'Leather Seats Dressing', 'Dash & Doors Dressing', 'Door Jambs', 'Trunk Vacuum', 'Air Freshener', 'Double Wheel Clean & Tire Dressing'))
                )
            ),
            'van' => array(
                'id' => 'van',
                'name' => 'Full Size SUV',
                'icon' => 'fa-solid fa-shuttle-van',
                'packages' => array(
                    array('title' => 'Exterior Only', 'price' => 40, 'time' => '45min', 'features' => array('100% Hand Wash & Hand Dry', 'Tire & Wheel Clean', 'Tire Dressing', 'Foam Wax', 'Exterior Windows', 'Fast, Quality Refresh')),
                    array('title' => 'Deluxe', 'price' => 50, 'time' => '1h 15min', 'features' => array('Everything in Exterior Only', 'Full Interior Vacuum', 'Floor Mats Vacuum', 'Wipe-down (Dash, Doors, Consoles)', 'Air Freshener')),
                    array('title' => 'Premium', 'price' => 65, 'time' => '1h 30min', 'features' => array('Full Interior + Exterior Wash', 'Rainbow Triple Coat Foam', 'All 4 Rubber/Plastic Mats Cleaned', 'All 4 Cloth Mats Shampooed', 'Leather Seats Dressing', 'Dash & Doors Dressing', 'Door Jambs', 'Trunk Vacuum', 'Air Freshener', 'Double Wheel Clean & Tire Dressing'))
                )
            ),
            'truck' => array(
                'id' => 'truck',
                'name' => 'Pickup Truck',
                'icon' => 'fa-solid fa-truck-pickup',
                'packages' => array(
                    array('title' => 'Exterior Only', 'price' => 30, 'time' => '45min', 'features' => array('100% Hand Wash & Hand Dry', 'Tire & Wheel Clean', 'Tire Dressing', 'Foam Wax', 'Exterior Windows', 'Fast, Quality Refresh')),
                    array('title' => 'Deluxe', 'price' => 40, 'time' => '1h 15min', 'features' => array('Everything in Exterior Only', 'Full Interior Vacuum', 'Floor Mats Vacuum', 'Wipe-down (Dash, Doors, Consoles)', 'Air Freshener')),
                    array('title' => 'Premium', 'price' => 55, 'time' => '1h 30min', 'features' => array('Full Interior + Exterior Wash', 'Rainbow Triple Coat Foam', 'All 4 Rubber/Plastic Mats Cleaned', 'All 4 Cloth Mats Shampooed', 'Leather Seats Dressing', 'Dash & Doors Dressing', 'Door Jambs', 'Trunk Vacuum', 'Air Freshener', 'Double Wheel Clean & Tire Dressing'))
                )
            ),
            'tesla' => array(
                'id' => 'tesla',
                'name' => 'Tesla',
                'icon' => 'fa-solid fa-bolt',
                'packages' => array(
                    array('title' => 'Exterior Only', 'price' => 30, 'time' => '45min', 'features' => array('100% Hand Wash & Hand Dry', 'Tire & Wheel Clean', 'Tire Dressing', 'Foam Wax', 'Exterior Windows', 'Fast, Quality Refresh')),
                    array('title' => 'Deluxe', 'price' => 40, 'time' => '1h 15min', 'features' => array('Everything in Exterior Only', 'Full Interior Vacuum', 'Floor Mats Vacuum', 'Wipe-down (Dash, Doors, Consoles)', 'Air Freshener')),
                    array('title' => 'Premium', 'price' => 55, 'time' => '1h 30min', 'features' => array('Full Interior + Exterior Wash', 'Rainbow Triple Coat Foam', 'All 4 Rubber/Plastic Mats Cleaned', 'All 4 Cloth Mats Shampooed', 'Leather Seats Dressing', 'Dash & Doors Dressing', 'Door Jambs', 'Trunk Vacuum', 'Air Freshener', 'Double Wheel Clean & Tire Dressing'))
                )
            )
        );
    }

    /**
     * Admin Menu
     */
    public function add_admin_menu() {
        add_options_page(
            'Car Wash Widget Settings',
            'Car Wash Widget',
            'manage_options',
            'carwash-widget',
            array($this, 'render_admin_page')
        );
    }

    public function enqueue_admin_scripts($hook) {
        if ($hook != 'settings_page_carwash-widget') {
            return;
        }
        // Using FontAwesome for icon preview in admin
        wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
    }

    /**
     * Admin Page Renderer
     */
    public function render_admin_page() {
        // Save logic
        if (isset($_POST['cw_save_data']) && check_admin_referer('cw_save_action', 'cw_nonce')) {
            $json_data = stripslashes($_POST['cw_widget_json']);
            $decoded = json_decode($json_data, true);
            if ($decoded) {
                update_option($this->option_name, $decoded);
                echo '<div class="notice notice-success is-dismissible"><p>Settings saved successfully.</p></div>';
            } else {
                echo '<div class="notice notice-error is-dismissible"><p>Error: Invalid JSON data.</p></div>';
            }
        }

        $current_data = get_option($this->option_name, $this->get_default_data());
        ?>
        <div class="wrap">
            <h1>Car Wash Widget Settings</h1>
            <p>Use the interface below to configure your car types and pricing packages. Use the shortcode <code>[cw_widget]</code> to display the widget.</p>
            
            <form method="post" id="cw-admin-form">
                <?php wp_nonce_field('cw_save_action', 'cw_nonce'); ?>
                <input type="hidden" name="cw_widget_json" id="cw_widget_json" value='<?php echo esc_attr(json_encode($current_data)); ?>'>
                <input type="hidden" name="cw_save_data" value="1">

                <div id="cw-admin-app" style="display: flex; gap: 20px; margin-top: 20px;">
                    <!-- Left Sidebar: Vehicles -->
                    <div style="width: 250px; flex-shrink: 0;">
                        <div style="background: #fff; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                            <div style="padding: 10px; border-bottom: 1px solid #ccd0d4; font-weight: bold; background: #f9f9f9; display:flex; justify-content:space-between; align-items:center;">
                                <span>Vehicles</span>
                                <button type="button" class="button button-small" id="add-vehicle-btn">Add New</button>
                            </div>
                            <ul id="vehicle-list" style="margin: 0;">
                                <!-- List items injected via JS -->
                            </ul>
                        </div>
                    </div>

                    <!-- Right Content: Details -->
                    <div style="flex-grow: 1; background: #fff; border: 1px solid #ccd0d4; padding: 20px; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                        <div id="vehicle-editor" style="display:none;">
                            <h2 style="margin-top:0;">Edit Vehicle</h2>
                            
                            <table class="form-table">
                                <tr>
                                    <th scope="row"><label>ID (Internal)</label></th>
                                    <td><input type="text" id="edit-v-id" class="regular-text" readonly style="background:#f0f0f1;"></td>
                                </tr>
                                <tr>
                                    <th scope="row"><label>Display Name</label></th>
                                    <td><input type="text" id="edit-v-name" class="regular-text"></td>
                                </tr>
                                <tr>
                                    <th scope="row"><label>FontAwesome Icon</label></th>
                                    <td>
                                        <input type="text" id="edit-v-icon" class="regular-text" placeholder="fa-solid fa-car">
                                        <span id="icon-preview" style="font-size: 20px; margin-left: 10px;"></span>
                                        <p class="description">Enter class names (e.g., <code>fa-solid fa-car</code>)</p>
                                    </td>
                                </tr>
                            </table>

                            <div style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px;">
                                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 15px;">
                                    <h3 style="margin:0;">Packages</h3>
                                    <button type="button" class="button" id="add-package-btn">Add Package</button>
                                </div>
                                <div id="packages-container">
                                    <!-- Packages injected via JS -->
                                </div>
                            </div>
                            
                            <div style="margin-top: 20px; border-top: 1px solid #eee; padding-top: 20px; text-align: right;">
                                <button type="button" class="button button-link-delete" id="delete-vehicle-btn">Delete Vehicle</button>
                            </div>
                        </div>
                        <div id="no-selection" style="text-align: center; padding: 40px; color: #666;">
                            <p>Select a vehicle from the list to edit.</p>
                        </div>
                    </div>
                </div>

                <p class="submit">
                    <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
                </p>
            </form>
        </div>

        <style>
            .vehicle-list-item { padding: 10px 15px; border-bottom: 1px solid #eee; cursor: pointer; transition: background 0.2s; display: flex; align-items: center; }
            .vehicle-list-item:hover { background: #f0f0f1; }
            .vehicle-list-item.active { background: #0073aa; color: #fff; }
            .package-card { background: #fafafa; border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 4px; position: relative; }
            .package-remove { position: absolute; top: 10px; right: 10px; color: #a00; cursor: pointer; text-decoration: none; }
            .cw-form-row { margin-bottom: 10px; }
            .cw-form-row label { display: block; font-weight: 500; margin-bottom: 4px; }
            .cw-form-row input[type="text"], .cw-form-row input[type="number"] { width: 100%; }
            .cw-form-row textarea { width: 100%; height: 80px; }
        </style>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            let data = JSON.parse(document.getElementById('cw_widget_json').value);
            // Convert object to array for easier handling if it's an object, keeping ID references
            // The storage format is an object keyed by ID. We'll work with that.
            
            let currentVehicleId = null;

            const vehicleList = document.getElementById('vehicle-list');
            const editor = document.getElementById('vehicle-editor');
            const noSelection = document.getElementById('no-selection');
            const jsonInput = document.getElementById('cw_widget_json');

            function renderList() {
                vehicleList.innerHTML = '';
                Object.values(data).forEach(vehicle => {
                    const li = document.createElement('li');
                    li.className = 'vehicle-list-item ' + (currentVehicleId === vehicle.id ? 'active' : '');
                    li.innerHTML = `<i class="${vehicle.icon}" style="margin-right:10px; width:20px; text-align:center;"></i> ${vehicle.name}`;
                    li.onclick = () => selectVehicle(vehicle.id);
                    vehicleList.appendChild(li);
                });
            }

            function selectVehicle(id) {
                currentVehicleId = id;
                noSelection.style.display = 'none';
                editor.style.display = 'block';
                renderList();
                
                const v = data[id];
                document.getElementById('edit-v-id').value = v.id;
                document.getElementById('edit-v-name').value = v.name;
                document.getElementById('edit-v-icon').value = v.icon;
                document.getElementById('icon-preview').className = v.icon;

                renderPackages(v.packages);
            }

            function renderPackages(packages) {
                const container = document.getElementById('packages-container');
                container.innerHTML = '';
                packages.forEach((pkg, idx) => {
                    const div = document.createElement('div');
                    div.className = 'package-card';
                    div.innerHTML = `
                        <span class="package-remove dashicons dashicons-trash" title="Remove Package"></span>
                        <div style="display:flex; gap: 10px;">
                            <div class="cw-form-row" style="flex:2">
                                <label>Title</label>
                                <input type="text" class="pkg-title" value="${escapeHtml(pkg.title)}">
                            </div>
                            <div class="cw-form-row" style="flex:1">
                                <label>Price ($)</label>
                                <input type="number" class="pkg-price" value="${pkg.price}">
                            </div>
                            <div class="cw-form-row" style="flex:1">
                                <label>Time</label>
                                <input type="text" class="pkg-time" value="${escapeHtml(pkg.time)}">
                            </div>
                        </div>
                        <div class="cw-form-row">
                            <label>Features (One per line)</label>
                            <textarea class="pkg-features">${pkg.features.join('\n')}</textarea>
                        </div>
                    `;
                    
                    // Events to update data model immediately
                    div.querySelector('.pkg-title').oninput = (e) => { data[currentVehicleId].packages[idx].title = e.target.value; updateJson(); };
                    div.querySelector('.pkg-price').oninput = (e) => { data[currentVehicleId].packages[idx].price = parseFloat(e.target.value) || 0; updateJson(); };
                    div.querySelector('.pkg-time').oninput = (e) => { data[currentVehicleId].packages[idx].time = e.target.value; updateJson(); };
                    div.querySelector('.pkg-features').oninput = (e) => { 
                        data[currentVehicleId].packages[idx].features = e.target.value.split('\n').filter(line => line.trim() !== ''); 
                        updateJson(); 
                    };
                    div.querySelector('.package-remove').onclick = () => {
                        if(confirm('Delete this package?')) {
                            data[currentVehicleId].packages.splice(idx, 1);
                            renderPackages(data[currentVehicleId].packages);
                            updateJson();
                        }
                    };

                    container.appendChild(div);
                });
            }

            // Input handlers for vehicle details
            document.getElementById('edit-v-name').oninput = (e) => {
                if(currentVehicleId) {
                    data[currentVehicleId].name = e.target.value;
                    renderList(); // Re-render name in list
                    updateJson();
                }
            };
            document.getElementById('edit-v-icon').oninput = (e) => {
                if(currentVehicleId) {
                    data[currentVehicleId].icon = e.target.value;
                    document.getElementById('icon-preview').className = e.target.value;
                    renderList(); // Re-render icon in list
                    updateJson();
                }
            };

            // Add Vehicle
            document.getElementById('add-vehicle-btn').onclick = () => {
                const id = 'v_' + Date.now();
                data[id] = {
                    id: id,
                    name: 'New Vehicle',
                    icon: 'fa-solid fa-car',
                    packages: []
                };
                selectVehicle(id);
                updateJson();
            };

            // Delete Vehicle
            document.getElementById('delete-vehicle-btn').onclick = () => {
                if(confirm('Are you sure you want to delete this vehicle type?')) {
                    delete data[currentVehicleId];
                    currentVehicleId = null;
                    editor.style.display = 'none';
                    noSelection.style.display = 'block';
                    renderList();
                    updateJson();
                }
            };

            // Add Package
            document.getElementById('add-package-btn').onclick = () => {
                if(currentVehicleId) {
                    data[currentVehicleId].packages.push({
                        title: 'New Service',
                        price: 0,
                        time: '1h',
                        features: ['Feature 1', 'Feature 2']
                    });
                    renderPackages(data[currentVehicleId].packages);
                    updateJson();
                }
            };

            function updateJson() {
                jsonInput.value = JSON.stringify(data);
            }

            function escapeHtml(text) {
                if (!text) return "";
                return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
            }

            renderList();
        });
        </script>
        <?php
    }

    /**
     * Shortcode Renderer
     */
    public function render_shortcode() {
        // Enqueue Assets specifically for the shortcode
        // Tailwind CDN (Note: In production, local CSS is preferred, but per request we use CDN)
        wp_enqueue_script('cw-tailwind', 'https://cdn.tailwindcss.com', array(), null, false);
        wp_enqueue_style('cw-fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
        
        $data = get_option($this->option_name, $this->get_default_data());
        
        // Output HTML
        ob_start();
        ?>
        <!-- CW Widget Styles -->
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
            .cw-widget-container { font-family: 'Inter', sans-serif; width: 100%; color: #000; }
            .cw-widget-container .theme-accent { color: #f7b21b; }
            .cw-widget-container .bg-theme-accent { background-color: #f7b21b; }
            .cw-widget-container .border-theme-accent { border-color: #f7b21b; }
            .cw-widget-container .bg-premium-dark { background: linear-gradient(145deg, #1a1a1a 0%, #000000 100%); }
            .cw-widget-container .hover-glow { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
            .cw-widget-container .hover-glow:hover { border-color: #f7b21b; box-shadow: 0 10px 30px -10px rgba(247, 178, 27, 0.3); transform: translateY(-8px); }
            .cw-widget-container .active-vehicle { background-color: #f7b21b; color: #000000; border: none; box-shadow: 0 0 20px rgba(247, 178, 27, 0.4); transform: scale(1.05); font-weight: 700; }
            .cw-widget-container .inactive-vehicle { background: linear-gradient(145deg, #1a1a1a 0%, #000000 100%); color: #ffffff; border: 1px solid #333; }
            .cw-widget-container .inactive-vehicle:hover { border-color: #555; background: linear-gradient(145deg, #252525 0%, #0a0a0a 100%); }
            .cw-widget-container .price-card { border-radius: 6px; opacity: 0; transform: translateY(20px); animation: cwFadeInUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; border: 1px solid #2a2a2a; }
            @keyframes cwFadeInUp { to { opacity: 1; transform: translateY(0); } }
            .cw-widget-container .currency-symbol { font-size: 0.5em; vertical-align: top; position: relative; top: 0.2em; font-weight: 500; }
            .cw-widget-container .cents { font-size: 0.4em; vertical-align: top; position: relative; top: 0.2em; font-weight: 500; }
            .cw-widget-container li { display: flex; align-items: flex-start; text-align: left; }
            .cw-widget-container li::before { content: "✓"; color: #f7b21b; margin-right: 8px; font-weight: bold; flex-shrink: 0; }
        </style>

        <div class="cw-widget-container p-4 md:p-10">
            <div class="w-full max-w-7xl mx-auto">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-16" id="cwVehicleSelector"></div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8" id="cwPricingContainer"></div>
            </div>
        </div>

        <script>
        (function() {
            // Pass PHP data to JS
            const pricingData = <?php echo json_encode($data); ?>;
            // Get keys to preserve order if needed, or just Object.keys
            const vehicleKeys = Object.keys(pricingData);
            let currentSelection = vehicleKeys[0]; // Default to first

            function renderVehicleButtons() {
                const container = document.getElementById('cwVehicleSelector');
                if(!container) return;
                container.innerHTML = ''; 

                vehicleKeys.forEach(type => {
                    const data = pricingData[type];
                    const isSelected = currentSelection === type;
                    
                    const btn = document.createElement('div');
                    const baseClasses = "vehicle-btn cursor-pointer rounded-md p-6 flex flex-col items-center justify-center h-32";
                    const activeClass = "active-vehicle";
                    const inactiveClass = "inactive-vehicle";

                    btn.className = `${baseClasses} ${isSelected ? activeClass : inactiveClass}`;
                    
                    let iconHtml = `<i class="${data.icon} text-3xl mb-3"></i>`;
                    
                    btn.innerHTML = `
                        ${iconHtml}
                        <span class="text-sm md:text-base text-center tracking-wide">${data.name}</span>
                    `;

                    btn.addEventListener('click', () => {
                        currentSelection = type;
                        renderVehicleButtons(); 
                        renderPricingCards();   
                    });

                    container.appendChild(btn);
                });
            }

            function renderPricingCards() {
                const container = document.getElementById('cwPricingContainer');
                if(!container) return;
                
                container.style.opacity = '0';
                
                setTimeout(() => {
                    container.innerHTML = ''; 
                    const data = pricingData[currentSelection];

                    if(data && data.packages) {
                        data.packages.forEach((pkg, index) => {
                            const card = document.createElement('div');
                            card.style.animationDelay = `${index * 0.15}s`;
                            card.className = "price-card bg-premium-dark text-white p-8 flex flex-col items-center text-center h-full min-h-[420px] hover-glow relative overflow-hidden";
                            
                            const featuresHtml = pkg.features.map(f => `<li class="mb-3 text-gray-300 text-sm leading-relaxed">${f}</li>`).join('');

                            const priceDisplay = `
                                <div class="theme-accent text-6xl font-light my-6 flex items-start justify-center font-sans tracking-tight">
                                    <span class="currency-symbol text-2xl mt-2">$</span>
                                    <span>${pkg.price}</span>
                                    <span class="cents text-2xl mt-2">00</span>
                                </div>
                            `;

                            card.innerHTML = `
                                <h3 class="text-2xl font-semibold mb-2 tracking-wide uppercase text-gray-100">${pkg.title}</h3>
                                ${priceDisplay}
                                <div class="w-full border-t border-gray-800 my-4"></div>
                                <div class="flex items-center justify-center theme-accent mb-6 bg-gray-900/50 py-2 px-4 rounded-full border border-gray-800">
                                    <i class="fa-regular fa-clock mr-2"></i>
                                    <span class="font-medium tracking-wide">${pkg.time}</span>
                                </div>
                                <div class="w-full border-t border-gray-800 mb-6"></div>
                                <ul class="flex-grow w-full px-2">
                                    ${featuresHtml}
                                </ul>
                            `;
                            container.appendChild(card);
                        });
                    }
                    container.style.opacity = '1';
                }, 300);
            }

            // Init
            if(document.getElementById('cwVehicleSelector')) {
                renderVehicleButtons();
                renderPricingCards();
            }
        })();
        </script>
        <?php
        return ob_get_clean();
    }
}

new CW_Car_Wash_Widget();
