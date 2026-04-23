# Farm Supply Inventory System ERD

This ERD was updated from the current Laravel migrations in `database/migrations`.

## Scope

Included:
- core inventory and warehouse operations
- sales and stock receipt flow
- customer ordering and engagement
- governance and audit tables

Omitted for clarity:
- `cache`, `cache_locks`
- `jobs`, `job_batches`, `failed_jobs`
- `password_reset_tokens`, `sessions`
- `personal_access_tokens`
- dropped `sms_messages`

## Core Operations

```mermaid
erDiagram
    ROLES ||--o{ USERS : assigns
    BRANCHES ||--o{ WAREHOUSES : contains
    CATEGORIES ||--o{ PRODUCTS : groups
    SUPPLIERS ||--o{ PRODUCTS : supplies
    PRODUCTS ||--o{ INVENTORY : tracked_in
    WAREHOUSES ||--o{ INVENTORY : stores
    SUPPLIERS ||--o{ INVENTORY : sources
    PRODUCTS ||--o{ TRANSACTIONS : logs
    INVENTORY ||--o{ TRANSACTIONS : affects
    WAREHOUSES ||--o{ TRANSACTIONS : occurs_in
    USERS ||--o{ TRANSACTIONS : posts
    SUPPLIERS ||--o{ TRANSACTIONS : references
    SUPPLIERS ||--o{ STOCK_RECEIPTS : owns
    USERS ||--o{ STOCK_RECEIPTS : receives
    STOCK_RECEIPTS ||--o{ STOCK_RECEIPT_ITEMS : contains
    PRODUCTS ||--o{ STOCK_RECEIPT_ITEMS : received_as
    USERS ||--o{ SALES : customer_or_cashier
    SALES ||--o{ SALE_ITEMS : contains
    PRODUCTS ||--o{ SALE_ITEMS : sold_as
    SALES ||--o{ TRANSACTIONS : linked_to

    ROLES {
        bigint id PK
        string role_name
    }
    USERS {
        bigint id PK
        bigint role_id FK
        string name
        string email
        string phone
        string address
        string role
        string status
        json permissions_override
    }
    BRANCHES {
        bigint id PK
        string code
        string name
        string location
        string contact_person
        string phone
        boolean is_active
    }
    WAREHOUSES {
        bigint id PK
        bigint branch_id FK
        string code
        string name
        string location
        string manager_name
        string phone
        boolean is_active
    }
    CATEGORIES {
        bigint id PK
        string slug
        string name
        text description
        boolean is_active
    }
    SUPPLIERS {
        bigint id PK
        string name
        string contact_person
        string email
        string phone
        text address
        string tax_number
        boolean is_active
    }
    PRODUCTS {
        bigint id PK
        bigint category_id FK
        bigint supplier_id FK
        string sku
        string barcode
        string name
        decimal unit_price
        string unit_of_measure
        int current_stock
        int reorder_point
        boolean is_active
    }
    INVENTORY {
        bigint id PK
        bigint product_id FK
        bigint warehouse_id FK
        bigint supplier_id FK
        string batch_number
        int quantity
        decimal unit_cost
        decimal selling_price
        date expiry_date
        string status
    }
    TRANSACTIONS {
        bigint id PK
        bigint product_id FK
        bigint inventory_id FK
        bigint warehouse_id FK
        bigint user_id FK
        bigint supplier_id FK
        bigint sale_id FK
        string transaction_number
        string transaction_type
        int quantity
        decimal total_amount
    }
    STOCK_RECEIPTS {
        bigint id PK
        bigint supplier_id FK
        bigint received_by_user_id FK
        datetime received_at
        string reference_no
        text notes
    }
    STOCK_RECEIPT_ITEMS {
        bigint id PK
        bigint receipt_id FK
        bigint product_id FK
        string batch_number
        date manufacturing_date
        date expiry_date
        int quantity
        decimal unit_cost
        decimal line_total
    }
    SALES {
        bigint id PK
        bigint customer_user_id FK
        bigint cashier_user_id FK
        string sale_number
        datetime sold_at
        decimal subtotal
        decimal discount
        string discount_type
        decimal total
        string payment_method
        string gcash_reference_number
    }
    SALE_ITEMS {
        bigint id PK
        bigint sale_id FK
        bigint product_id FK
        int quantity
        decimal unit_price
        decimal line_total
    }
```

## Customer, Engagement, and Governance

```mermaid
erDiagram
    USERS ||--o{ ORDERS : places_or_processes
    ORDERS ||--o{ ORDER_ITEMS : contains
    PRODUCTS ||--o{ ORDER_ITEMS : ordered_as
    USERS ||--o{ CUSTOMER_REQUESTS : submits
    PRODUCTS ||--o{ CUSTOMER_REQUESTS : requested_for
    USERS ||--o{ FAVORITE_PRODUCTS : favorites
    PRODUCTS ||--o{ FAVORITE_PRODUCTS : saved_by
    USERS ||--o{ PRODUCT_REVIEWS : writes
    PRODUCTS ||--o{ PRODUCT_REVIEWS : reviewed_as
    USERS ||--o{ PROMOTIONS : creates
    USERS ||--o{ USER_NOTIFICATIONS : receives
    USERS ||--o{ LOGIN_ACTIVITIES : records
    USERS ||--o{ AUDIT_LOGS : creates
    USERS ||--o{ SYSTEM_SETTINGS : updates

    USERS {
        bigint id PK
        bigint role_id FK
        string name
        string email
        string status
    }
    PRODUCTS {
        bigint id PK
        bigint category_id FK
        bigint supplier_id FK
        string sku
        string name
        decimal unit_price
    }
    ORDERS {
        bigint id PK
        bigint customer_user_id FK
        bigint processed_by_user_id FK
        string order_number
        string status
        string payment_method
        decimal subtotal
        decimal discount
        decimal total
        datetime placed_at
        datetime processed_at
    }
    ORDER_ITEMS {
        bigint id PK
        bigint order_id FK
        bigint product_id FK
        int quantity
        decimal unit_price
        decimal line_total
    }
    CUSTOMER_REQUESTS {
        bigint id PK
        bigint user_id FK
        bigint product_id FK
        int requested_quantity
        string status
        text notes
        datetime processed_at
    }
    FAVORITE_PRODUCTS {
        bigint id PK
        bigint user_id FK
        bigint product_id FK
        datetime created_at
    }
    PRODUCT_REVIEWS {
        bigint id PK
        bigint user_id FK
        bigint product_id FK
        tinyint rating
        text review
        boolean is_approved
    }
    PROMOTIONS {
        bigint id PK
        bigint created_by_user_id FK
        string title
        string code
        string discount_type
        decimal discount_value
        datetime starts_at
        datetime ends_at
        boolean is_active
    }
    USER_NOTIFICATIONS {
        bigint id PK
        bigint user_id FK
        string type
        string title
        text message
        boolean is_read
        datetime read_at
    }
    LOGIN_ACTIVITIES {
        bigint id PK
        bigint user_id FK
        string email
        string action
        string ip_address
        json meta
        datetime created_at
    }
    AUDIT_LOGS {
        bigint id PK
        bigint user_id FK
        string action
        string entity_type
        string entity_id
        json details
        string ip_address
        datetime created_at
    }
    SYSTEM_SETTINGS {
        bigint id PK
        bigint updated_by_user_id FK
        string key
        json value
        string description
    }
```

## Source Migrations

Primary tables were derived from these migrations:
- `0001_01_01_000000_create_users_table.php`
- `2026_02_26_110057_create_categories_table.php`
- `2026_02_26_110058_create_suppliers_table.php`
- `2026_02_26_110058_create_products_table.php`
- `2026_02_26_110059_create_warehouses_table.php`
- `2026_02_26_110059_create_inventory_table.php`
- `2026_02_26_110100_create_transactions_table.php`
- `2026_03_04_000000_create_customer_requests_table.php`
- `2026_03_04_020000_apply_erd_schema_tables.php`
- `2026_03_05_000100_add_gcash_fields_to_sales_table.php`
- `2026_03_05_000200_add_discount_verification_fields_to_sales_table.php`
- `2026_03_05_000300_create_orders_and_engagement_tables.php`
- `2026_03_05_000350_add_profile_and_permission_columns_to_users_table.php`
- `2026_03_05_000400_create_super_admin_system_tables.php`
- `2026_03_05_000500_create_branches_and_sms_messages_tables.php`
- `2026_03_07_000300_add_batch_fields_to_stock_receipt_items_table.php`
