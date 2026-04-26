# Chapter 2: Design Artifacts and Analysis

## VI. Wireframes

The actual Farm Supply Inventory System uses a shared application shell with a left sidebar, a top header, and role-based views. After login, the first screen depends on the user role:

- `customer` users land on `Customer Home`
- `staff` users land on `Staff Desk`
- `manager`, `admin`, and `super_admin` users land on `Dashboard`

Because the PDF requires a dashboard wireframe, the diagram below follows the real `Dashboard` page used by manager, admin, and super admin users in the current system.

### A. Dashboard Page Wireframe

Representative screen: `dashboardView`

```text
+------------------------------------------------------------------------------------------------------------------+
| SIDEBAR                                                                 | TOP HEADER                             |
| Farm Supply Inventory                                                   | Dashboard                              |
| Daily inventory workspace                                               | See stock, sales, and alerts at a glance. |
| [Control Center pill]                                                   | User box | Refresh | Logout            |
|                                                                                                                  |
| Dashboard                                                                                                        |
| Staff Desk (role-based)                                                                                            |
| Home / Shop / My Orders / Favorites / Profile (customer-only)                                                     |
| POS / POS Counter (role-based)                                                                                     |
| Operations                                                                                                         |
| Reports / Shift Reports (role-based)                                                                               |
| Users (admin+)                                                                                                     |
| Super Admin (super_admin only)                                                                                     |
+------------------------------------------------------------------------------------------------------------------+
| ADMIN OVERVIEW / WORKSPACE GUIDE                                                                                   |
| Check today's priorities first.                                                                                   |
| [Open Stock Tasks] [Open Reports]                                                                                 |
| [1. Watch] [2. Update] [3. Review]                                                                                |
+------------------------------------------------------------------------------------------------------------------+
| KPI CARDS                                                                                                         |
| Products | Active Products | Low Stock | Out Of Stock | Inventory Value | Today Sales | Month Sales | Suppliers |
| Branches                                                                                                          |
+------------------------------------------------------------------------------------------------------------------+
| Low-Stock Watch                                      | Recent Activity                                            |
| Product | Stock | Reorder | Status                  | transaction number | type | product | qty | date          |
+------------------------------------------------------------------------------------------------------------------+
| Top Movers                                           | Stock by Category          | Monthly Sales                 |
| Product | Moved Qty                                  | Category | Stock           | Month | Total                 |
+------------------------------------------------------------------------------------------------------------------+
```

Annotations:

1. The left sidebar is the shared navigation shell of the system. Some menu items only appear for specific roles.
2. The top header always shows the current view title, subtitle, active user, `Refresh`, and `Logout`.
3. The dashboard begins with the `Admin overview` guide panel and its shortcut buttons.
4. The workflow strip is not generic decoration. It matches the real dashboard guidance used in the system: `Watch`, `Update`, and `Review`.
5. The KPI area reflects the exact metrics loaded by the dashboard API: products, active products, low stock, out of stock, inventory value, today sales, month sales, suppliers, and branches.
6. The `Low-Stock Watch` table displays products below reorder point.
7. The `Recent Activity` panel lists recent stock transactions.
8. The lower analytics area includes `Top Movers`, `Stock by Category`, and `Monthly Sales`.
9. This wireframe is aligned with the real `dashboardView` in `resources/views/welcome.blade.php`.

### B. Main Transaction Page Wireframe

Representative transaction: `POS Counter / Point of Sale`

The current system has several transactions, but the clearest dedicated transaction page in the actual UI is the `POS` screen. It is also directly connected to the `Staff Desk` through the `Open POS` action.

```text
+------------------------------------------------------------------------------------------------------------------+
| TOP HEADER                                                                                                       |
| Point of Sale | Process sales and review recent counter activity.                                                |
| User box | Refresh | Logout                                                                                     |
+------------------------------------------------------------------------------------------------------------------+
| POS HERO / STEP STRIP                                                                                            |
| Fast counter checkout                                                                                            |
| Warehouse label + live stock source                                                                              |
| [1 Select warehouse] [2 Add products] [3 Complete payment]                                                       |
| Catalog items | Available units | Cart items | Grand total                                                       |
+------------------------------------------------------------------------------------------------------------------+
| 1. PICK PRODUCTS                                          | 2. REVIEW AND PAY                                    |
| Warehouse select                                          | Customer name (optional)                              |
| Search product / SKU / category                           | Payment method: Cash / GCash                          |
| Apply Filter / Clear Search                               | Discount type: None / Senior / PWD                    |
| Live product cards with:                                  | Discount amount                                       |
| - product name                                            | Senior/PWD ID number (conditional)                    |
| - SKU and unit                                            | Senior/PWD proof upload (conditional)                 |
| - stock badge                                             | Amount tendered (cash)                                |
| - price                                                   | Cash quick buttons: Exact / +100 / +500 / +1000       |
| - available units                                         | GCash reference number (conditional)                  |
| - reorder point                                           | GCash receipt upload (conditional)                    |
| - batch / expiry info                                     | Notes                                                 |
| - qty input + Add to Sale                                 | Sale cart with editable line quantities               |
|                                                           | Items | Subtotal | Discount | Grand total             |
|                                                           | Amount tendered | Balance due | Change                |
|                                                           | Payment status | Complete Sale                        |
+------------------------------------------------------------------------------------------------------------------+
| 3. SALE RESULT / RECENT POS SALES                                                                                 |
| Success summary card after checkout                                                                              |
| Print Last Receipt                                                                                               |
| Recent POS Sales table: Sale # | Cashier | Items | Total | Payment | GCash Ref | Date                          |
+------------------------------------------------------------------------------------------------------------------+
```

Annotations:

1. The POS page starts with a dedicated `POS Workspace` hero, not with a plain form.
2. The warehouse selector is required because the catalog is warehouse-aware and loads live stock from the chosen branch warehouse.
3. Product cards show quantity, stock, price, reorder point, and batch or expiry context before adding to sale.
4. The payment area changes dynamically based on the chosen method and discount type.
5. Cash mode shows `Amount Tendered` and quick cash buttons, while GCash mode shows reference and receipt upload fields.
6. Senior and PWD discounts reveal ID number and ID proof inputs because the real system supports verified discount handling.
7. The cart is editable directly from the checkout panel, and the total summary includes subtotal, discount, grand total, balance due, change, and payment status.
8. After a successful sale, the result appears in the `Sale result` card and can be printed through `Print Last Receipt`.
9. This wireframe is aligned with the real `posView` in the system.

## VII. Task Analysis

Main transaction analyzed: Staff POS checkout

| Step | User Action | System Response |
| --- | --- | --- |
| 1 | A staff user opens the Farm Supply Inventory System and logs in. | The system authenticates the account and opens the `Staff Desk` as the default staff landing screen. |
| 2 | The user clicks `Open POS` from `Staff Desk`, or opens `POS Counter` from the sidebar. | The system switches to the `Point of Sale` view. |
| 3 | The user selects a warehouse. | The system loads the live POS catalog, warehouse label, stock source note, catalog count, available units, cart items, and grand total header metrics. |
| 4 | The user searches the catalog and enters item quantities. | The system filters product cards and shows availability, reorder point, batch count, and nearest expiry where applicable. |
| 5 | The user clicks `Add to Sale` on one or more products. | The system places the products in the sale cart and updates items, subtotal, discount, grand total, and payment status. |
| 6 | The user enters optional customer name, selects payment method, and chooses a discount type. | The system reveals the correct conditional fields such as cash tendered, GCash reference and receipt upload, or senior/PWD verification inputs. |
| 7 | The user reviews the cart and adjusts quantities if needed. | The system recalculates subtotal, discount, amount tendered, balance due, and change in real time. |
| 8 | The user clicks `Complete Sale`. | Laravel validation checks the request fields, required proof inputs, payment readiness, and stock availability in the selected warehouse. |
| 9 | If the transaction is valid, the system stores the sale. | The system creates sale records, sale items, and related stock-out transactions, and deducts inventory from the correct warehouse batches. |
| 10 | The transaction finishes successfully. | The system shows the success summary in `Sale result`, adds the sale to `Recent POS Sales`, and enables `Print Last Receipt`. |

This flow matches the real staff transaction experience more closely than the earlier customer-only checkout description.

## VIII. Gantt Chart

The following schedule presents a practical development timeline for the Farm Supply Inventory System.

| Task | Start Date | End Date | Duration | W1 | W2 | W3 | W4 | W5 | W6 | W7 | W8 |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| Project Planning | February 2, 2026 | February 6, 2026 | 5 days | X |  |  |  |  |  |  |  |
| Database Design (ERD, migrations) | February 9, 2026 | February 13, 2026 | 5 days |  | X |  |  |  |  |  |  |
| Wireframing and UI/UX | February 16, 2026 | February 20, 2026 | 5 days |  |  | X |  |  |  |  |  |
| Backend Development (Models, Controllers, Routes) | February 23, 2026 | March 6, 2026 | 10 days |  |  |  | X | X |  |  |  |
| Frontend Development (Blade, CSS, JS) | March 2, 2026 | March 13, 2026 | 10 days |  |  |  |  | X | X |  |  |
| Testing and Debugging | March 16, 2026 | March 20, 2026 | 5 days |  |  |  |  |  |  | X |  |
| Documentation and Finalization | March 23, 2026 | March 27, 2026 | 5 days |  |  |  |  |  |  |  | X |

## IX. Entity-Relationship Diagram (ERD)

The Farm Supply Inventory System uses a relational database that connects user access, catalog data, inventory records, transactions, orders, sales, reviews, notifications, and governance records.

### Simplified ERD View

```text
ROLES 1 ---- * USERS
BRANCHES 1 ---- * WAREHOUSES
CATEGORIES 1 ---- * PRODUCTS
SUPPLIERS 1 ---- * PRODUCTS
SUPPLIERS 1 ---- * INVENTORY
PRODUCTS 1 ---- * INVENTORY
WAREHOUSES 1 ---- * INVENTORY
PRODUCTS 1 ---- * TRANSACTIONS
INVENTORY 1 ---- * TRANSACTIONS
USERS 1 ---- * TRANSACTIONS

USERS 1 ---- * ORDERS
ORDERS 1 ---- * ORDER_ITEMS
PRODUCTS 1 ---- * ORDER_ITEMS
USERS 1 ---- * USER_NOTIFICATIONS
USERS 1 ---- * PRODUCT_REVIEWS
PRODUCTS 1 ---- * PRODUCT_REVIEWS
USERS 1 ---- * CUSTOMER_REQUESTS
PRODUCTS 1 ---- * CUSTOMER_REQUESTS

USERS 1 ---- * SALES
SALES 1 ---- * SALE_ITEMS
PRODUCTS 1 ---- * SALE_ITEMS
```

### Main Entities and Sample Attributes

| Entity | Sample Attributes |
| --- | --- |
| Roles | `id`, `role_name` |
| Users | `id`, `role_id`, `name`, `email`, `phone`, `address`, `status` |
| Categories | `id`, `slug`, `name`, `description`, `is_active` |
| Suppliers | `id`, `name`, `contact_person`, `email`, `phone` |
| Products | `id`, `category_id`, `supplier_id`, `sku`, `name`, `unit_price`, `current_stock`, `reorder_point` |
| Branches | `id`, `code`, `name`, `location`, `is_active` |
| Warehouses | `id`, `branch_id`, `code`, `name`, `location`, `is_active` |
| Inventory | `id`, `product_id`, `warehouse_id`, `supplier_id`, `batch_number`, `quantity`, `unit_cost`, `selling_price`, `expiry_date`, `status` |
| Transactions | `id`, `product_id`, `inventory_id`, `warehouse_id`, `user_id`, `transaction_type`, `quantity`, `total_amount` |
| Orders | `id`, `customer_user_id`, `processed_by_user_id`, `order_number`, `status`, `payment_method`, `total` |
| Order Items | `id`, `order_id`, `product_id`, `quantity`, `unit_price`, `line_total` |
| Sales | `id`, `customer_user_id`, `cashier_user_id`, `sale_number`, `payment_method`, `discount_type`, `total` |
| Sale Items | `id`, `sale_id`, `product_id`, `quantity`, `unit_price`, `line_total` |
| User Notifications | `id`, `user_id`, `type`, `title`, `message`, `data` |

### Relationship Summary

1. One role can be assigned to many users.
2. One branch can contain many warehouses.
3. One category can group many products.
4. One supplier can provide many products and inventory batches.
5. One product can appear in many inventory records, order items, sale items, and transaction logs.
6. One order can contain many order items, while one sale can contain many sale items.
7. One user can create many orders, receive many notifications, submit reviews or requests, and perform stock or sales transactions depending on role.

Note: the full editable ERD source for the project is maintained in `docs/Farm_Supply_Inventory_System_ERD_Labeled.drawio`, while relationship notes are maintained in `docs/Farm_Supply_Inventory_System_ERD.md`.
