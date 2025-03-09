# UIU-RP

The **UIU Research Portal (UIURP)** is a web-based platform designed to facilitate and promote research activities at United International University (UIU). It serves as a hub where students and faculty members can explore research projects, connect with mentors, and collaborate on academic initiatives. The portal provides essential features such as research project listings, faculty profiles, keyword-based search functionality, and a discussion forum to enhance engagement within the university's research community. 

---

## **Windows Setup**

### **1. Install MongoDB Community Edition**

i. **Download MongoDB**:

   - Visit the official MongoDB download page: [MongoDB Download Center](https://www.mongodb.com/try/download/community).
   - Select **Windows** as the operating system.
   - Choose the **MSI Installer** (easier installation).
   - Click **Download**.

ii. **Run the Installer**:

   - Double-click the downloaded **MSI** file.
   - Follow the installation wizard:
     - Choose **Complete** installation.
     - Ensure **Install MongoDB as a Service** is checked.
     - Leave the default port **27017** (or change if necessary).
   - Click **Install** and complete the setup.

iii. **Verify Installation**:

   - Open **Command Prompt** (`Win + R` → type `cmd` → press Enter).
   - Run the following command to check if MongoDB is installed:
     ```bash
     mongod --version
     ```
   - If the command works, MongoDB is installed successfully.

---

### **2. Install MongoDB Compass (GUI Tool) + setup MongoDB Atlas**

i. **Download MongoDB Compass**:

   - Visit the official download page: [MongoDB Compass Download](https://www.mongodb.com/products/compass).
   - Select **Windows** and download the installer.

ii. **Run the Installer**:

   - Double-click the installer and follow the setup instructions.

iii. **Connect MongoDB Compass to UIURP**:

   - If you are using MongoDB Compass, follow these steps:
   - Open MongoDB Compass.
   - Click New Connection.
   - In the Connection String field, paste:
     ```perl
        mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/
     ```
   - Click Connect.
   - If successful, you will see your database and collections.

---
### **3. Clone repo + run**

i. **Clone Project**:

   - Open Command Prompt (Win + R → type cmd → Enter).
   - Navigate to the XAMPP htdocs directory:
        ```bash
           cd C:\xampp\htdocs
        ```
   - Clone the UIURP repository:
        ``` bash
           git clone https://github.com/syed-nafis/uiurp.git
        ```
ii. **Start Apache Web Server**:

   - Open XAMPP Control Panel.
   - Click Start next to Apache.
   - Open a browser and visit:
        ```arduino
           http://localhost/uiurp/
        ```
        The UIU Research Portal should now be running!
   

## **macOS Setup**

### **1. Install MongoDB Community Edition**

MongoDB is installed on macOS via **Homebrew**.

i. **Install Homebrew** (if not already installed):

   - Open **Terminal** and run:
     ```bash
     /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
     ```

ii. **Install MongoDB**:

   - Run the following command:
     ```bash
     brew tap mongodb/brew
     brew install mongodb-community@7.0
     ```
   - Replace `7.0` with the latest MongoDB version if needed.

iii. **Start MongoDB Service**:

   - Run:
     ```bash
     brew services start mongodb-community@7.0
     ```

iv. **Verify Installation**:

   - Run:
     ```bash
     mongod --version
     ```
   - If it returns a version number, MongoDB is installed successfully.

---

### **2. Install MongoDB Compass**

i. **Download MongoDB Compass**:

   - Visit: [MongoDB Compass Download](https://www.mongodb.com/products/compass).
   - Select **macOS** and download the `.dmg` file.

ii. **Install MongoDB Compass**:

   - Open the **.dmg** file.
   - Drag the **MongoDB Compass** icon to the **Applications** folder.

iii. **Connect MongoDB Compass to UIURP**:

   - Open MongoDB Compass.
   - Click New Connection.
   - In the Connection String field, paste:
     ```perl
        mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/
     ```
   - Click Connect.
   - If successful, you will see your database and collections.

### **3. Run**:

i. **Clone Project**:

   - Open Terminal
   - Navigate to prefered directory
   - Clone the UIURP repository:
        ``` bash
           git clone https://github.com/syed-nafis/uiurp.git
        ```
   - Move into the project folder:
        ```bash
              cd uiurp
        ```

ii. **Use Built in PHP server**

   - use PHP's built-in server to run the project.
   - Make sure you are inside the project folder:
   - Start the PHP development server:
      ```bash
           php -S localhost:8000
      ```
   - Open a browser and visit:
      ```bash
           http://localhost:8000/
      ```
      The UIU Research Portal should now be running!

---

## **Conclusion**

**For further assistance ask ChatGPT**
