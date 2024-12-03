# Offer Collections for Lovata Shopaholic Plugin (OctoberCMS)

**Developed by Logingrupa**

## Overview

This plugin extends the functionalities of the [Lovata Shopaholic plugin](https://octobercms.com/plugin/lovata-shopaholic) for OctoberCMS, allowing for advanced management of offer collections. It adds backend management tools, frontend components, and logic to enhance the Shopaholic ecosystem.

---


## Features

- Create, manage, and display collections of offers.
- Fully integrated with Lovata Shopaholic.
- Modular backend functionality.
- Provides components for frontend rendering.
- Custom database schema for collections and offers.

---

## Installation

1. Run
```bash
php artisan plugin:install Logingrupa.OfferCollectionsShopaholic --from=git@github.com:logingrupa/oc-offercollectionsshopaholic-plugin.git --want=dev-master --oc

```
---

## File Structure and Functionality

### **Plugin Core**
- **`Plugin.php`**  
  The main entry point for the plugin. Defines bootstrapping logic and plugin dependencies.

  **Key functions:**
  - `registerComponents()` - Registers frontend components like `CollectionList` and `CollectionPage`.
  - `registerSettings()` - Adds settings options in the OctoberCMS backend.
  - `boot()` - Sets up event listeners and binds behaviors to models.

- **`plugin.yaml`**  
  Metadata file that defines the plugin's name, author, and dependencies.

---

### **Classes**

#### **`classes/collection/CollectionCollection.php`**
Manages the logic for collections, such as retrieving data and filtering collections.

**Key methods:**
- `getActive()` - Returns active collections based on custom logic.
- `applyFilters($query, $filters)` - Applies filtering criteria to the collection query.

#### **`classes/item/CollectionItem.php`**
Defines individual items within a collection.

**Key methods:**
- `getItemData()` - Retrieves data for a specific item.
- `calculateDiscount()` - Calculates the discount for an offer item.

#### **`classes/store/CollectionListStore.php`**
Handles the storage and retrieval of collection data for list views.

**Key methods:**
- `getStoreData()` - Fetches data from the store based on conditions.
- `sortData($query, $criteria)` - Applies sorting logic to the collection data.

#### **Event Handlers**
- **`BackendMenuHandler.php`**  
  Dynamically updates the backend menu structure for better navigation.
- **`CollectionModelHandler.php`**  
  Manages event hooks for the `Collection` model, such as `onBeforeSave`.

---

### **Components**

#### **`components/CollectionData.php`**
Provides raw data for a specific collection to frontend templates.

**Key properties and methods:**
- `property int $collectionId` - The ID of the collection.
- `onRun()` - Executes when the component is initialized.

#### **`components/CollectionList.php`**
Displays a list of collections in the frontend.

**Key properties and methods:**
- `property string $sortOrder` - Sorting criteria for collections.
- `loadCollections()` - Loads collections based on filters and sorting.

#### **`components/CollectionPage.php`**
Displays the details of a single collection.

**Key properties and methods:**
- `property int $collectionSlug` - Slug to identify the collection.
- `loadCollection()` - Fetches and loads collection data for the page.

---

### **Controllers**

#### **`controllers/Collections.php`**
Manages backend operations for collections, including CRUD functionality.

**Key features:**
- Supports list, create, edit, and delete operations.
- Integrates with OctoberCMS's backend UI features.

#### Configurations:
- **`config_form.yaml`** - Defines the structure of the collection form in the backend.
- **`config_list.yaml`** - Specifies the list view configuration for collections.
- **`_config_filter.yaml`** - Adds filtering options to the collection list.

---

### **Models**

#### **`models/Collection.php`**
Primary model for managing offer collections.

**Key properties and methods:**
- `public $fillable` - Defines fillable attributes for mass assignment.
- `scopeActive($query)` - Adds a scope to retrieve only active collections.

#### Model Configurations:
- **`columns.yaml`** - Defines the columns displayed in the backend list view.
- **`fields.yaml`** - Configures fields used in the backend forms.

---

### **Database Migrations**

- **`create_table_collections.php`**  
  Creates the `collections` table to store basic collection information.

- **`create_table_collection_offer.php`**  
  Creates a pivot table for many-to-many relationships between collections and offers.

- **`update_table_collections_add_aditional_fields.php`**  
  Adds new fields to the `collections` table to support additional metadata.

---

### **Language Support**

- **`lang/en/lang.php`**  
  Provides English translations for labels, messages, and errors used in the backend.

---



