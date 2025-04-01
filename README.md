
# 🖼️ Gallery Shop

**Gallery Shop** is an advanced online marketplace for buying and selling images and graphics developed with Laravel. This system provides extensive management features for admins and an optimized user experience for customers, offering a complete and efficient platform.

With this platform, users can easily search and filter for the images they want, add them to their shopping cart, and after purchase, receive the relevant files via email. On the other hand, site administrators can fully manage products, categories, users, and sales, and monitor sales growth through an analytical dashboard.

## 🚀 Key Features

### 🎛️ **Admin Panel**

- 📦 **Product Management** (Add, Edit, Delete)
- 👤 **User Management** (Add, Edit, Delete)
- 📊 **Professional Analytical Dashboard** (Displays the number of sales, users, products, and categories)
- 📈 **Monthly and Yearly Growth Charts** for sales performance analysis
- 💳 **Transaction Management** (Details of successful and unsuccessful payments)
- 📑 **Access to the full list of sales** with detailed information
- 🔍 **Advanced Search** across all management tables
- ✉️ **Automatic email sending** with purchased files to users

### 🛍️ **User Features**

- ⚡ **Quick and easy product viewing**
- 🔍 **Filter products by category**
- 🆕 **Sort by latest, cheapest, and most expensive**
- 💰 **Set a price range to display related products**
- 🖼️ **View similar products on the product page**
- 🛒 **Add and remove products from the shopping cart**
- 🍪 **Save shopping cart in cookies without the need to log in**

## 🔧 Technologies Used

- **Laravel** - A powerful PHP framework for backend development
- **MySQL** - Database for storing user and product information
- **Verta** - A package for converting dates to Persian for better statistical data presentation

## 🛠️ Installation and Setup

### 1️⃣ Clone the repository
 `git clone https://github.com/yourusername/gallery-shop.git cd gallery-shop `

### 2️⃣ Set up the database and email configurations

Edit the `.env` file and set up your database and email settings:

 `DB_DATABASE=your_database_name DB_USERNAME=your_database_user DB_PASSWORD=your_database_password MAIL_MAILER=smtp MAIL_HOST=smtp.your-email.com MAIL_PORT=587 MAIL_USERNAME=your_email@example.com MAIL_PASSWORD=your_email_password MAIL_ENCRYPTION=tls MAIL_FROM_ADDRESS=your_email@example.com `

### 3️⃣ Run Laravel commands
 `composer install php artisan migrate --seed php artisan key:generate `

### 4️⃣ Start the local server
 `php artisan serve ` 
Then, the project will be accessible at `http://127.0.0.1:8000`.

## 📞 Contact Information

- **LinkedIn:** [Mohamadreza Salehi](https://www.linkedin.com/in/mohamadreza-salehi)
- **Email:** mr.salehi.dev@gmail.com
- **Website:** [iammohamadrezasale](https://iammohamadrezasale.com)

### 🎨 Gallery Shop is a professional digital marketplace for art and graphics enthusiasts. With this platform, you will experience a smooth, fast, and efficient process for buying and selling digital images. 🚀
