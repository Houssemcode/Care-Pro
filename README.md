# 🛡️ Care-Pro | Premium Caregiving Marketplace

Care-Pro is a sophisticated, role-based ecosystem built with Laravel 11, designed to bridge the gap between families in need of specialized care and qualified professional caregivers. The platform provides a secure, verified marketplace for both **Child Care** and **Elderly Care** services.

---

## 🌟 Key Features

### 👨‍👩‍👧‍👦 For Families
- **Smart Discovery**: Find qualified caregivers using distance-based searching and location filters.
- **Seamless Booking**: Request services directly through a caregiver's offer with specific date ranges.
- **Secure Communication**: Integrated messaging system to coordinate details with caregivers.
- **Quality Assurance**: Rate caregivers and submit reports to ensure a high standard of care.
- **Profile Management**: Manage home localization and personal settings for better matching.

### 👩‍⚕️ For Caregivers (Employees)
- **Professional Showcase**: Create detailed profiles including diplomas, experience, and specialized descriptions.
- **Offer Management**: Publish service offers specifying location (Wilaya/Commune), service type, and living arrangements (Live-in/Live-out).
- **Request Workflow**: Receive and manage service requests with the ability to accept or reject.
- **Verification System**: Upload professional credentials for administrative validation.
- **Availability Control**: Update profiles and offers in real-time to reflect current availability.

### 🛡️ For Administrators
- **Verification Engine**: Review employee documents and approve/suspend profiles to maintain platform trust.
- **Global Oversight**: Monitor all requests, offers, and user activities from a centralized dashboard.
- **Conflict Resolution**: Review and manage user reports to resolve disputes and maintain quality.
- **User Governance**: Comprehensive management of users, including status toggling and profile auditing.
- **System Configuration**: Manage global platform settings and administrative access.

---

## ⚙️ Technical Stack

- **Backend**: [Laravel 11](https://laravel.com) (PHP 8.2+)
- **Frontend**: Blade Templates, [Tailwind CSS](https://tailwindcss.com), [Vite](https://vitejs.dev)
- **Database**: MySQL 8.0+ / MariaDB 10.3+
- **Auth**: Custom Role-Based Access Control (RBAC) via `RoleMiddleware`
- **Geodata**: Haversine Formula implementation for distance calculation and Google Maps integration.

---

## 🚀 Getting Started

### Prerequisites
- **PHP**: 8.2+ (with `bcmath`, `ctype`, `curl`, `dom`, `mbstring`, `openssl`, `pdo`, `tokenizer`, `xml` extensions)
- **Composer**: Latest version
- **Node.js**: 18.x+ (LTS)
- **MySQL**: 8.0+ or MariaDB 10.3+

### Installation

1. **Clone & Install Dependencies**
   ```bash
   git clone https://github.com/Houssemcode/Care-Pro.git
   cd care-pro
   composer install
   npm install
   ```

2. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Edit `.env` to configure your database credentials and set your `ADMIN_MASTER_KEY`.*

3. **Database Initialization**
   ```bash
   php artisan migrate
   php artisan storage:link
   ```

4. **Development Server**
   ```bash
   # Start the Laravel server and Vite compiler
   composer dev 
   ```
   The app will be available at `http://127.0.0.1:8000`.

---

## 🧪 Testing with Sample Data

To quickly test the platform's full functionality, we provide a comprehensive test dataset.

### Load Test Data
Run the following command to wipe the database and populate it with a realistic set of Admins, Employees, Families, Offers, and Requests:
```bash
php artisan migrate:fresh --seed
```

### Test Accounts
| Role | Email | Password | Note |
| :--- | :--- | :--- | :--- |
| **Admin** | `admin@carepro.dz` | `password` | Full system access |
| **Employee** | `amel@example.com` | `password` | Active caregiver profile |
| **Family** | `ahmed@family.com` | `password` | Example family account |

---

## 📊 Database Architecture

The system utilizes a relational schema to ensure data integrity and efficient querying:

- **Users**: Central identity table managing authentication and basic contact info.
- **Admins/Employees/Families**: Role-specific tables linked to `users` via 1:1 relationships.
- **Offres**: Detailed service offerings created by employees, linked to location and service type.
- **Requests**: The bridge between Families and Offres, tracking booking status (`pending`, `assigned`, `rejected`).
- **Reports/Ratings**: Feedback loop for quality control and caregiver evaluation.
- **BookingMessages**: Secure communication logs between families and caregivers.

---

## 🔐 Security Note
The `ADMIN_MASTER_KEY` in the `.env` file is used to authorize the creation of the first administrative account. Ensure this key is kept secret in production environments.
