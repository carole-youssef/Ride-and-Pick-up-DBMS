import java.io.IOException;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.sql.Statement;
import java.sql.ResultSet;
import java.util.Scanner;

/**
 * This program demonstrates how to make database connection with Oracle
 * Includes CRUD operations for Passenger table
 */
public class JdbcOracleConnectionTemplate {

    // Method to display the main menu
    private static void mainMenu(Connection conn) {
        try (Scanner scanner = new Scanner(System.in)) {
            String choice = "";

            while (!choice.equals("E")) {
                // Clear the console output
                System.out.println("\n".repeat(50));
                
                // Display menu
                System.out.println("=================================================================");
                System.out.println("| Oracle All Inclusive Tool                                      |");
                System.out.println("| Main Menu - Select Desired Operation(s):                       |");
                System.out.println("| <CTRL-Z Anytime to Enter Interactive CMD Prompt>              |");
                System.out.println("----------------------------------------------------------------");
                System.out.println(" 1) Drop Tables");
                System.out.println(" 2) Create Tables");
                System.out.println(" 3) Populate Tables");
                System.out.println(" 4) Query Tables");
                System.out.println(" 5) Passenger Management");
                System.out.println(" E) End/Exit");
                System.out.print("Choose: ");

                choice = scanner.nextLine().toUpperCase();

                switch (choice) {
                    case "1":
                        dropTables(conn);
                        pause();
                        break;
                    case "2":
                        createTables(conn);
                        pause();
                        break;
                    case "3":
                        populateTables(conn);
                        pause();
                        break;
                    case "4":
                        queryTables(conn);
                        pause();
                        break;
                    case "5":
                        passengerMenu(conn);
                        break;
                    case "E":
                        System.out.println("Exiting program.");
                        break;
                    default:
                        System.out.println("Invalid option. Please try again.");
                }
            }
        }
    }

    // New method for passenger management menu
    private static void passengerMenu(Connection conn) {
        Scanner scanner = new Scanner(System.in);
        String choice = "";

        while (!choice.equals("B")) {
            System.out.println("\n".repeat(50));
            System.out.println("=================================================================");
            System.out.println("| Passenger Management                                           |");
            System.out.println("----------------------------------------------------------------");
            System.out.println(" 1) View All Passengers");
            System.out.println(" 2) Search Passenger");
            System.out.println(" 3) Add New Passenger");
            System.out.println(" 4) Update Passenger");
            System.out.println(" 5) Delete Passenger");
            System.out.println(" B) Back to Main Menu");
            System.out.print("Choose: ");

            choice = scanner.nextLine().toUpperCase();

            switch (choice) {
                case "1":
                    viewAllPassengers(conn);
                    pause();
                    break;
                case "2":
                    searchPassenger(conn);
                    pause();
                    break;
                case "3":
                    addPassenger(conn);
                    pause();
                    break;
                case "4":
                    updatePassenger(conn);
                    pause();
                    break;
                case "5":
                    deletePassenger(conn);
                    pause();
                    break;
                case "B":
                    break;
                default:
                    System.out.println("Invalid option. Please try again.");
            }
        }
    }

    // Method to view all passengers
    private static void viewAllPassengers(Connection conn) {
        String sql = "SELECT * FROM Passenger ORDER BY passenger_ID";
        try (PreparedStatement stmt = conn.prepareStatement(sql);
             ResultSet rs = stmt.executeQuery()) {
            
            System.out.println("\nAll Passengers:");
            System.out.println("----------------------------------------------------------------");
            System.out.printf("%-5s %-20s %-15s %-25s %-12s %-8s%n", 
                "ID", "Name", "Phone", "Email", "Join Date", "Points");
            System.out.println("----------------------------------------------------------------");
            
            while (rs.next()) {
                System.out.printf("%-5d %-20s %-15s %-25s %-12s %-8d%n",
                    rs.getInt("passenger_ID"),
                    rs.getString("p_fullname"),
                    rs.getString("p_phone"),
                    rs.getString("p_email"),
                    rs.getDate("join_date"),
                    rs.getInt("loyalty_points"));
            }
        } catch (SQLException e) {
            System.out.println("Error viewing passengers: " + e.getMessage());
        }
    }

    // Method to search for a passenger
    private static void searchPassenger(Connection conn) {
        Scanner scanner = new Scanner(System.in);
        System.out.println("\nSearch by:");
        System.out.println("1) ID");
        System.out.println("2) Name");
        System.out.print("Choose: ");
        
        String searchChoice = scanner.nextLine();
        String sql = "";
        
        try {
            PreparedStatement stmt;
            switch (searchChoice) {
                case "1":
                    System.out.print("Enter Passenger ID: ");
                    int id = Integer.parseInt(scanner.nextLine());
                    sql = "SELECT * FROM Passenger WHERE passenger_ID = ?";
                    stmt = conn.prepareStatement(sql);
                    stmt.setInt(1, id);
                    break;
                    
                case "2":
                    System.out.print("Enter Passenger Name (or part of name): ");
                    String name = scanner.nextLine();
                    sql = "SELECT * FROM Passenger WHERE LOWER(p_fullname) LIKE LOWER(?)";
                    stmt = conn.prepareStatement(sql);
                    stmt.setString(1, "%" + name + "%");
                    break;
                    
                default:
                    System.out.println("Invalid choice");
                    return;
            }
            
            ResultSet rs = stmt.executeQuery();
            System.out.println("\nSearch Results:");
            System.out.println("----------------------------------------------------------------");
            System.out.printf("%-5s %-20s %-15s %-25s %-12s %-8s%n", 
                "ID", "Name", "Phone", "Email", "Join Date", "Points");
            System.out.println("----------------------------------------------------------------");
            
            while (rs.next()) {
                System.out.printf("%-5d %-20s %-15s %-25s %-12s %-8d%n",
                    rs.getInt("passenger_ID"),
                    rs.getString("p_fullname"),
                    rs.getString("p_phone"),
                    rs.getString("p_email"),
                    rs.getDate("join_date"),
                    rs.getInt("loyalty_points"));
            }
            
            rs.close();
            stmt.close();
        } catch (SQLException e) {
            System.out.println("Error searching for passenger: " + e.getMessage());
        }
    }

    // Method to add a new passenger
    private static void addPassenger(Connection conn) {
        Scanner scanner = new Scanner(System.in);
        
        try {
            System.out.println("\nAdd New Passenger");
            System.out.println("----------------------------------------------------------------");
            
            // Get next available ID
            String maxIdSql = "SELECT MAX(passenger_ID) FROM Passenger";
            int nextId = 1;
            try (Statement stmt = conn.createStatement();
                 ResultSet rs = stmt.executeQuery(maxIdSql)) {
                if (rs.next()) {
                    nextId = rs.getInt(1) + 1;
                }
            }
            
            System.out.print("Enter Full Name: ");
            String fullName = scanner.nextLine();
            
            System.out.print("Enter Phone Number: ");
            String phone = scanner.nextLine();
            
            System.out.print("Enter Email: ");
            String email = scanner.nextLine();
            
            String sql = "INSERT INTO Passenger (passenger_ID, p_fullname, p_phone, p_email, join_date, loyalty_points) " +
                        "VALUES (?, ?, ?, ?, CURRENT_DATE, 0)";
            
            try (PreparedStatement pstmt = conn.prepareStatement(sql)) {
                pstmt.setInt(1, nextId);
                pstmt.setString(2, fullName);
                pstmt.setString(3, phone);
                pstmt.setString(4, email);
                
                int rowsAffected = pstmt.executeUpdate();
                if (rowsAffected > 0) {
                    System.out.println("Passenger added successfully!");
                }
            }
        } catch (SQLException e) {
            System.out.println("Error adding passenger: " + e.getMessage());
        }
    }

    // Method to update a passenger
    private static void updatePassenger(Connection conn) {
        Scanner scanner = new Scanner(System.in);
        
        System.out.print("\nEnter Passenger ID to update: ");
        try {
            int id = Integer.parseInt(scanner.nextLine());
            
            // First check if passenger exists
            String checkSql = "SELECT * FROM Passenger WHERE passenger_ID = ?";
            try (PreparedStatement checkStmt = conn.prepareStatement(checkSql)) {
                checkStmt.setInt(1, id);
                ResultSet rs = checkStmt.executeQuery();
                
                if (!rs.next()) {
                    System.out.println("Passenger not found!");
                    return;
                }
                
                System.out.println("Current passenger details:");
                System.out.printf("Name: %s%nPhone: %s%nEmail: %s%nLoyalty Points: %d%n",
                    rs.getString("p_fullname"),
                    rs.getString("p_phone"),
                    rs.getString("p_email"),
                    rs.getInt("loyalty_points"));
            }
            
            System.out.println("\nEnter new details:");
            
            System.out.print("New Name: ");
            String newName = scanner.nextLine();
            
            System.out.print("New Phone: ");
            String newPhone = scanner.nextLine();
            
            System.out.print("New Email: ");
            String newEmail = scanner.nextLine();
            
            System.out.print("New Loyalty Points: ");
            int newPointsStr = scanner.nextInt();
            
            String sql = "UPDATE Passenger SET " +
                        "p_fullname = ?, " +
                        "p_phone = ?, " +
                        "p_email = ?, " +
                        "loyalty_points = ? " +
                        "WHERE passenger_ID = ?";
            
            try (PreparedStatement pstmt = conn.prepareStatement(sql)) {
                pstmt.setString(1, newName);
                pstmt.setString(2, newPhone);
                pstmt.setString(3, newEmail);
                pstmt.setInt(4, newPointsStr);
                pstmt.setInt(5, id);
                
                int rowsAffected = pstmt.executeUpdate();
                if (rowsAffected > 0) {
                    System.out.println("Passenger updated successfully!");
                }
            }
        } catch (SQLException e) {
            System.out.println("Error updating passenger: " + e.getMessage());
        } catch (NumberFormatException e) {
            System.out.println("Invalid ID format!");
        }
    }

    // Method to delete a passenger
    private static void deletePassenger(Connection conn) {
        Scanner scanner = new Scanner(System.in);
        
        System.out.print("\nEnter Passenger ID to delete: ");
        try {
            int id = Integer.parseInt(scanner.nextLine());
            
            // First check if passenger exists
            String checkSql = "SELECT p_fullname FROM Passenger WHERE passenger_ID = ?";
            try (PreparedStatement checkStmt = conn.prepareStatement(checkSql)) {
                checkStmt.setInt(1, id);
                ResultSet rs = checkStmt.executeQuery();
                
                if (!rs.next()) {
                    System.out.println("Passenger not found!");
                    return;
                }
                
                String passengerName = rs.getString("p_fullname");
                System.out.println("Are you sure you want to delete passenger: " + passengerName + "? (Y/N)");
                String confirm = scanner.nextLine().toUpperCase();
                
                if (confirm.equals("Y")) {
                    String sql = "DELETE FROM Passenger WHERE passenger_ID = ?";
                    try (PreparedStatement pstmt = conn.prepareStatement(sql)) {
                        pstmt.setInt(1, id);
                        int rowsAffected = pstmt.executeUpdate();
                        if (rowsAffected > 0) {
                            System.out.println("Passenger deleted successfully!");
                        }
                    }
                } else {
                    System.out.println("Delete operation cancelled.");
                }
            }
        } catch (SQLException e) {
            System.out.println("Error deleting passenger: " + e.getMessage());
        } catch (NumberFormatException e) {
            System.out.println("Invalid ID format!");
        }
    }

    // Method for dropping tables
    private static void dropTables(Connection conn) {
        String[] dropTableQueries = {
        "DROP TABLE Route CASCADE CONSTRAINTS",
        "DROP TABLE Takes CASCADE CONSTRAINTS",
        "DROP TABLE Vehicle CASCADE CONSTRAINTS",
        "DROP TABLE Has CASCADE CONSTRAINTS",
        "DROP TABLE Feedbck CASCADE CONSTRAINTS",
        "DROP TABLE PassengerAddress CASCADE CONSTRAINTS",
        "DROP TABLE Payment CASCADE CONSTRAINTS",
        "DROP TABLE Promotion CASCADE CONSTRAINTS",
        "DROP TABLE Ride CASCADE CONSTRAINTS",
        "DROP TABLE Driver CASCADE CONSTRAINTS",
        "DROP TABLE Passenger CASCADE CONSTRAINTS"
        };

        try (Statement stmt = conn.createStatement()) {
            for (String query : dropTableQueries) {
                try {
                    stmt.executeUpdate(query);  // Execute each DROP TABLE statement
                    System.out.println("Successfully dropped table: " + query.split(" ")[2]);  // Print table name
                } catch (SQLException e) {
                    // If an error occurs for a specific query, print an error message
                    System.out.println("Error while dropping table: " + query.split(" ")[2]);
                    System.out.println("SQL Error: " + e.getMessage());
                }
            }
        } catch (SQLException e) {
            System.out.println("Error creating statement: " + e.getMessage());
        }
    }


    // Method for creating tables (example action)
    public static void createTables(Connection conn) {
        // Array of CREATE TABLE queries
        String[] createTableQueries = {
            // Passenger table
            "CREATE TABLE Passenger (" +
                "passenger_ID     INTEGER NOT NULL PRIMARY KEY, " +
                "p_fullname       VARCHAR(255) NOT NULL, " +
                "p_phone          VARCHAR(15) NOT NULL, " +
                "p_email          VARCHAR(255), " +
                "join_date        DATE, " +
                "loyalty_points   INTEGER)",
            
            // Driver table
            "CREATE TABLE Driver (" +
                "driver_ID        INTEGER PRIMARY KEY, " +
                "d_fullname       VARCHAR(255) NOT NULL, " +
                "d_phone          VARCHAR(15) NOT NULL, " +
                "d_email          VARCHAR(255), " +
                "license_plate    VARCHAR(15) NOT NULL, " +
                "d_status         VARCHAR(50), " +
                "join_date        DATE)",

            // Vehicle table
            "CREATE TABLE Vehicle (" +
                "vehicle_ID       INTEGER PRIMARY KEY, " +
                "v_model          VARCHAR(255), " +
                "v_capacity       INTEGER, " +
                "license_plate    VARCHAR(15) NOT NULL, " +
                "driver_ID        INTEGER, " +
                "CONSTRAINT FK_driver_ID_vehicle FOREIGN KEY (driver_ID) REFERENCES Driver(driver_ID))",

            // Ride table
            "CREATE TABLE Ride (" +
                "ride_ID          INTEGER NOT NULL PRIMARY KEY, " +
                "driver_ID        INTEGER, " +
                "passenger_ID     INTEGER, " +
                "start_time       TIMESTAMP, " +
                "end_time         TIMESTAMP, " +
                "distance         DECIMAL(5,2), " +
                "fee              DECIMAL(10,2), " +
                "r_status         VARCHAR(50), " +
                "CONSTRAINT FK_driver_ID_ride FOREIGN KEY (driver_ID) REFERENCES Driver(driver_ID), " +
                "CONSTRAINT FK_passenger_ID_ride FOREIGN KEY (passenger_ID) REFERENCES Passenger(passenger_ID))",

            // Takes table
            "CREATE TABLE takes (" +
                "passenger_ID    INTEGER REFERENCES Passenger(passenger_ID), " +
                "ride_ID         INTEGER REFERENCES Ride(ride_ID), " +
                "t_date          DATE, " +
                "t_time          TIMESTAMP, " +
                "PRIMARY KEY (passenger_ID, ride_ID))",

            // PassengerAddress table
            "CREATE TABLE PassengerAddress (" +
                "passenger_ID    INTEGER REFERENCES Passenger(passenger_ID), " +
                "address         VARCHAR(255) NOT NULL, " +
                "PRIMARY KEY (passenger_ID))",

            // Route table
            "CREATE TABLE Route (" +
                "ride_ID          INTEGER, " +
                "start_pos        VARCHAR(255) NOT NULL, " +
                "end_pos          VARCHAR(255) NOT NULL, " +
                "distance         DECIMAL(5,2), " +
                "r_duration       INTEGER, " +
                "CONSTRAINT FK_ride_ID_route FOREIGN KEY(ride_ID) REFERENCES Ride(ride_ID))",

            // Promotion table
            "CREATE TABLE Promotion (" +
                "promotion_ID     INTEGER PRIMARY KEY, " +
                "code             VARCHAR(50) UNIQUE, " +
                "promo_type       VARCHAR(50), " +
                "discount_amount  DECIMAL(5,2), " +
                "start_date       DATE, " +
                "end_date         DATE, " +
                "active_status    NUMBER(1) NOT NULL)",

            // Payment table
            "CREATE TABLE Payment (" +
                "payment_ID       INTEGER PRIMARY KEY, " +
                "promotion_ID     INTEGER, " +
                "ride_ID          INTEGER, " +
                "passenger_ID     INTEGER, " +
                "fee              DECIMAL(10,2), " +
                "p_method         VARCHAR(50), " +
                "p_date           DATE, " +
                "p_status         VARCHAR(50), " +
                "CONSTRAINT FK_prom_ID_payment FOREIGN KEY (promotion_ID) REFERENCES Promotion(promotion_ID), " +
                "CONSTRAINT FK_rider_ID_payment FOREIGN KEY (ride_ID) REFERENCES Ride(ride_ID), " +
                "CONSTRAINT FK_passenger_ID_payment FOREIGN KEY (passenger_ID) REFERENCES Passenger(passenger_ID))",

            // Feedback table
            "CREATE TABLE Feedbck (" +
                "feedback_ID      INTEGER PRIMARY KEY, " +
                "ride_ID          INTEGER, " +
                "passenger_ID     INTEGER, " +
                "driver_ID        INTEGER, " +
                "memo             VARCHAR(50), " +
                "f_date           DATE, " +
                "f_time           TIMESTAMP, " +
                "CONSTRAINT FK_ride_ID_feedback FOREIGN KEY (ride_ID) REFERENCES Ride(ride_ID), " +
                "CONSTRAINT FK_passenger_ID_feedback FOREIGN KEY (passenger_ID) REFERENCES Passenger(passenger_ID), " +
                "CONSTRAINT FK_driver_ID_feedback FOREIGN KEY (driver_ID) REFERENCES Driver(driver_ID))",

            // Has table
            "CREATE TABLE Has (" +
                "driver_ID       INTEGER REFERENCES Driver(driver_ID), " +
                "feedback_ID     INTEGER REFERENCES Feedbck(feedback_ID), " +
                "passenger_ID    INTEGER REFERENCES Passenger(passenger_ID), " +
                "rating          INTEGER, " +
                "PRIMARY KEY (driver_ID, feedback_ID, passenger_ID))"
        };

        try (Statement stmt = conn.createStatement()) {
            for (String query : createTableQueries) {
                stmt.executeUpdate(query);  // Execute the CREATE TABLE statement
                System.out.println("Table created successfully.");
            }
        } catch (SQLException e) {
            System.out.println("Error creating tables: " + e.getMessage());
        }
    }

    // Method for populating tables (example action)
    private static void populateTables(Connection conn) {
        System.out.println("Populating tables...");
        String[] populateQueries = {
             // Populate Passenger table
            "INSERT INTO Passenger (passenger_ID, p_fullname, p_phone, p_email, join_date, loyalty_points) " +
            "VALUES (1, 'John Doe', '1234567890', 'john.doe@example.com', TO_DATE('2021-01-01', 'YYYY-MM-DD'), 100)",

            "INSERT INTO Passenger (passenger_ID, p_fullname, p_phone, p_email, join_date, loyalty_points) " +
            "VALUES (2, 'Jane Smith', '0987654321', 'jane.smith@example.com', TO_DATE('2021-05-15', 'YYYY-MM-DD'), 200)",

            "INSERT INTO Passenger (passenger_ID, p_fullname, p_phone, p_email, join_date, loyalty_points) " +
            "VALUES (3, 'Sam Lee', '1122334455', 'sam.lee@example.com', TO_DATE('2022-02-10', 'YYYY-MM-DD'), 150)",

            "INSERT INTO Passenger (passenger_ID, p_fullname, p_phone, p_email, join_date, loyalty_points) " +
            "VALUES (4, 'Lucy Brown', '2233445566', 'lucy.brown@example.com', TO_DATE('2023-07-20', 'YYYY-MM-DD'), 250)",

            "INSERT INTO Passenger (passenger_ID, p_fullname, p_phone, p_email, join_date, loyalty_points) " +
            "VALUES (5, 'Mike Johnson', '3344556677', 'mike.johnson@example.com', TO_DATE('2023-09-01', 'YYYY-MM-DD'), 300)",

            "INSERT INTO Passenger (passenger_ID, p_fullname, p_phone, p_email, join_date, loyalty_points) " +
            "VALUES (6, 'Amr Diab', '1289039443', 'amr.diab@egypt.com', TO_DATE('2021-09-21', 'YYYY-MM-DD'), 0)",

            // Populate Driver table
            "INSERT INTO Driver (driver_ID, d_fullname, d_phone, d_email, license_plate, d_status, join_date)" + 
            "VALUES (1, 'Alex Green', '1122334455', 'alex.green@example.com', 'ABC123', 'active', '2021-01-10')",

            "INSERT INTO Driver (driver_ID, d_fullname, d_phone, d_email, license_plate, d_status, join_date)" +
            "VALUES (2, 'Emma White', '2233445566', 'emma.white@example.com', 'XYZ789', 'active', '2021-06-20')",

            "INSERT INTO Driver (driver_ID, d_fullname, d_phone, d_email, license_plate, d_status, join_date)" +
            "VALUES (3, 'Tom Black', '3344556677', 'tom.black@example.com', 'DEF456', 'inactive', '2022-03-30')",

            "INSERT INTO Driver (driver_ID, d_fullname, d_phone, d_email, license_plate, d_status, join_date)" +
            "VALUES (4, 'Nina Gold', '4455667788', 'nina.gold@example.com', 'GHI012', 'active', '2022-11-05')",

            "INSERT INTO Driver (driver_ID, d_fullname, d_phone, d_email, license_plate, d_status, join_date)" + 
            "VALUES (5, 'Oliver Blue', '5566778899', 'oliver.blue@example.com', 'JKL345', 'inactive', '2023-04-18')",

            // Populate Vehicle table
            "INSERT INTO Vehicle (vehicle_ID, v_model, v_capacity, license_plate, driver_ID)" +
            "VALUES (1, 'Toyota Prius', 4, 'ABC123', 1)",

            "INSERT INTO Vehicle (vehicle_ID, v_model, v_capacity, license_plate, driver_ID)" +
            "VALUES (2, 'Honda Civic', 4, 'XYZ789', 2)",

            "INSERT INTO Vehicle (vehicle_ID, v_model, v_capacity, license_plate, driver_ID)" + 
            "VALUES (3, 'Ford F-150', 5, 'DEF456', 3)",

            "INSERT INTO Vehicle (vehicle_ID, v_model, v_capacity, license_plate, driver_ID)" + 
            "VALUES (4, 'Tesla Model 3', 5, 'GHI012', 4)",

            "INSERT INTO Vehicle (vehicle_ID, v_model, v_capacity, license_plate, driver_ID)" +
            "VALUES (5, 'Chevrolet Bolt', 4, 'JKL345', 5)",

            // Populate Ride table
            "INSERT INTO Ride (ride_ID, driver_ID, passenger_ID, start_time, end_time, distance, fee, r_status)" +
            "VALUES (1, 1, 1, '2024-09-01 08:00:00', '2024-09-01 08:30:00', 10.5, 25.00, 'completed')",

            "INSERT INTO Ride (ride_ID, driver_ID, passenger_ID, start_time, end_time, distance, fee, r_status)" +
            "VALUES (2, 2, 2, '2024-09-02 09:00:00', '2024-09-02 09:45:00', 15.2, 35.00, 'completed')",

            "INSERT INTO Ride (ride_ID, driver_ID, passenger_ID, start_time, end_time, distance, fee, r_status)" +
            "VALUES (3, 3, 3, '2024-09-03 10:00:00', '2024-09-03 10:30:00', 7.8, 20.00, 'completed')",

            "INSERT INTO Ride (ride_ID, driver_ID, passenger_ID, start_time, end_time, distance, fee, r_status)" +
            "VALUES (4, 4, 4, '2024-09-04 11:00:00', '2024-09-04 11:40:00', 12.0, 28.00, 'completed')",

            "INSERT INTO Ride (ride_ID, driver_ID, passenger_ID, start_time, end_time, distance, fee, r_status)" + 
            "VALUES (5, 5, 5, '2024-09-05 12:00:00', '2024-09-05 12:30:00', 8.9, 22.00, 'completed')" ,

            // Populate Takes table
            "INSERT INTO takes (passenger_ID, ride_ID, t_date, t_time)" +
            "VALUES (1, 1, '2024-09-01', '2024-09-01 08:00:00')",   

            "INSERT INTO takes (passenger_ID, ride_ID, t_date, t_time)" +
            "VALUES (2, 2, '2024-09-02', '2024-09-02 09:00:00')",

            "INSERT INTO takes (passenger_ID, ride_ID, t_date, t_time)" +
            "VALUES (3, 3, '2024-09-03', '2024-09-03 10:00:00')",

            "INSERT INTO takes (passenger_ID, ride_ID, t_date, t_time)" +
            "VALUES (4, 4, '2024-09-04', '2024-09-04 11:00:00')",

            "INSERT INTO takes (passenger_ID, ride_ID, t_date, t_time)" +
            "VALUES (5, 5, '2024-09-05', '2024-09-05 12:00:00')",
            
            // Populate PassengerAddress table
            "INSERT INTO PassengerAddress (passenger_ID, address)" +
            "VALUES (1, '123 Main St')",

            "INSERT INTO PassengerAddress (passenger_ID, address)" + 
            "VALUES (2, '456 Oak St')", 

            "INSERT INTO PassengerAddress (passenger_ID, address)" +
            "VALUES (3, '789 Pine St')",

            "INSERT INTO PassengerAddress (passenger_ID, address)" +
            "VALUES (4, '101 Maple Ave')",

            "INSERT INTO PassengerAddress (passenger_ID, address)" + 
            "VALUES (5, '202 Cedar Blvd')",

            // Populate Route table
            "INSERT INTO Route (ride_ID, start_pos, end_pos, distance, r_duration)" +
            "VALUES (1, '123 Main St', 'Downtown', 10.5, 30)",

            "INSERT INTO Route (ride_ID, start_pos, end_pos, distance, r_duration)" +
            "VALUES (2, '456 Oak St', 'City Center', 15.2, 45)",

            "INSERT INTO Route (ride_ID, start_pos, end_pos, distance, r_duration)" + 
            "VALUES (3, '789 Pine St', 'Uptown', 7.8, 25)",

            "INSERT INTO Route (ride_ID, start_pos, end_pos, distance, r_duration)" +
            "VALUES (4, '101 Maple Ave', 'Suburbia', 12.0, 40)",

            "INSERT INTO Route (ride_ID, start_pos, end_pos, distance, r_duration)" + 
            "VALUES (5, '202 Cedar Blvd', 'Airport', 8.9, 35)",

            // Populate Promotion table
            "INSERT INTO Promotion (promotion_ID, code, promo_type, discount_amount, start_date, end_date, active_status)" +
            "VALUES (1, 'SAVE10', 'Discount', 10.00, '2024-09-01', '2024-09-30', 1)",

            "INSERT INTO Promotion (promotion_ID, code, promo_type, discount_amount, start_date, end_date, active_status)" +
            "VALUES (2, 'SAVE20', 'Discount', 20.00, '2024-10-01', '2024-10-31', 1)",

            "INSERT INTO Promotion (promotion_ID, code, promo_type, discount_amount, start_date, end_date, active_status)" +
            "VALUES (3, 'HALFOFF', 'Discount', 50.00, '2024-11-01', '2024-11-30', 1)",

            "INSERT INTO Promotion (promotion_ID, code, promo_type, discount_amount, start_date, end_date, active_status)" +
            "VALUES (4, 'FREERIDE', 'Free Ride', 100.00, '2024-12-01', '2024-12-31', 1)",

            "INSERT INTO Promotion (promotion_ID, code, promo_type, discount_amount, start_date, end_date, active_status)" +
            "VALUES (5, 'NEWYEAR', 'Discount', 15.00, '2025-01-01', '2025-01-31', 0)",

            // Populate Payment table
            "INSERT INTO Payment (payment_ID, promotion_ID, ride_ID, passenger_ID, fee, p_method, p_date, p_status)" +
            "VALUES (1, NUll, 1, 1, 25.00, 'Credit Card', '2024-09-01', 'completed')",

            "INSERT INTO Payment (payment_ID, promotion_ID, ride_ID, passenger_ID, fee, p_method, p_date, p_status)" + 
            "VALUES (2, 1, 2, 2, 35.00, 'PayPal', '2024-09-02', 'completed')",

            "INSERT INTO Payment (payment_ID, promotion_ID, ride_ID, passenger_ID, fee, p_method, p_date, p_status)" +
            "VALUES (3, 1, 3, 3, 20.00, 'Debit Card', '2024-09-03', 'completed')",

            "INSERT INTO Payment (payment_ID, promotion_ID, ride_ID, passenger_ID, fee, p_method, p_date, p_status)" +
            "VALUES (4, NULL, 4, 4, 28.00, 'Credit Card', '2024-09-04', 'completed')",

            "INSERT INTO Payment (payment_ID, promotion_ID, ride_ID, passenger_ID, fee, p_method, p_date, p_status)" +
            "VALUES (5, 4, 5, 5, 22.00, 'Cash', '2024-09-05', 'completed')",

            // Populate Feedbck table 
            "INSERT INTO Feedbck (feedback_ID, ride_ID, passenger_ID, driver_ID, memo, f_date, f_time)" +
            "VALUES (1, 1, 1, 1, 'Great service!', '2024-09-01', '2024-09-01 09:00:00')",

            "INSERT INTO Feedbck (feedback_ID, ride_ID, passenger_ID, driver_ID, memo, f_date, f_time)" +
            "VALUES (2, 2, 2, 2, 'Very friendly driver.', '2024-09-02', '2024-09-02 10:00:00')",

            "INSERT INTO Feedbck (feedback_ID, ride_ID, passenger_ID, driver_ID, memo, f_date, f_time)" +
            "VALUES (3, 3, 3, 3, 'Smooth ride!', '2024-09-03', '2024-09-03 11:00:00')",

            "INSERT INTO Feedbck (feedback_ID, ride_ID, passenger_ID, driver_ID, memo, f_date, f_time)" +
            "VALUES (4, 4, 4, 4, 'Could be faster.', '2024-09-04', '2024-09-04 12:00:00')",

            "INSERT INTO Feedbck (feedback_ID, ride_ID, passenger_ID, driver_ID, memo, f_date, f_time)" + 
            "VALUES (5, 5, 5, 5, 'Excellent experience!', '2024-09-05', '2024-09-05 13:00:00')",

            // Populate Has table
            "INSERT INTO Has (driver_ID, feedback_ID, passenger_ID, rating)" +
            "VALUES (1, 1, 1, 5)",

            "INSERT INTO Has (driver_ID, feedback_ID, passenger_ID, rating)" +
            "VALUES (2, 2, 2, 4)",

            "INSERT INTO Has (driver_ID, feedback_ID, passenger_ID, rating)" +
            "VALUES (3, 3, 3, 5)",

            "INSERT INTO Has (driver_ID, feedback_ID, passenger_ID, rating)" +
            "VALUES (4, 4, 4, 3)",

            "INSERT INTO Has (driver_ID, feedback_ID, passenger_ID, rating)" +
            "VALUES (5, 5, 5, 5)"
        };
    
        try (Statement stmt = conn.createStatement()) {
            for (String query : populateQueries) {
                try {
                    stmt.executeUpdate(query);  // Execute each populate query
                    System.out.println("Successfully populated table: " + query.split(" ")[2]);  // Print table name
                } catch (SQLException e) {
                    // If an error occurs for a specific query, print an error message
                    System.out.println("Error while populating table: " + query.split(" ")[2]);
                    System.out.println("SQL Error: " + e.getMessage());
                }
            }
        } catch (SQLException e) {
            System.out.println("Error creating statement: " + e.getMessage());
        }
    }

    // Method for querying tables (example action)
    private static void queryTables(Connection conn) {
        // Query 1: Union of Drivers Who Are Active or Joined After 2022
                String sql1 = "SELECT driver_ID, d_fullname, d_status, join_date " +
                      "FROM Driver " +
                      "WHERE d_status = 'Active' " +
                      "UNION " +
                      "SELECT driver_ID, d_fullname, d_status, join_date " +
                      "FROM Driver " +
                      "WHERE join_date > TO_DATE('2022-01-01', 'YYYY-MM-DD')";
        try (PreparedStatement stmt = conn.prepareStatement(sql1);
            ResultSet rs = stmt.executeQuery()) {
            System.out.println("Union of Drivers Who Are Active or Joined After 2022:");
            System.out.println("\n");
            while (rs.next()) {
                System.out.printf("ID: %d, Name: %s, Status: %s, Join Date: %s%n",
                                  rs.getInt("driver_ID"), rs.getString("d_fullname"),
                                  rs.getString("d_status"), rs.getDate("join_date"));
            }
        } catch (SQLException e) {
            System.err.println("Error executing query 1: " + e.getMessage());
        }
        System.out.println("\n");

        // Query 2: Get passenger with ID 1, ride with feedback and ratings
                String sql2 = "SELECT P.p_fullname AS passenger_name, R.ride_ID, R.start_time, F.memo AS feedback, H.rating " +
                        "FROM Passenger P, Ride R, Feedbck F, Has H " +
                        "WHERE P.passenger_ID = R.passenger_ID " +
                        "AND R.ride_ID = F.ride_ID " +
                        "AND F.feedback_ID = H.feedback_ID " +
                        "AND P.passenger_ID = 1";

        try (PreparedStatement stmt = conn.prepareStatement(sql2);
            ResultSet rs = stmt.executeQuery()) {
            System.out.println("Passenger Ride Feedback and Ratings:");
            System.out.println("\n");
            while (rs.next()) {
                System.out.printf(
                    "Passenger Name: %s, Ride ID: %d, Start Time: %s, Feedback: %s, Rating: %d%n",
                    rs.getString("passenger_name"), rs.getInt("ride_ID"),
                    rs.getTimestamp("start_time"), rs.getString("feedback"),
                    rs.getInt("rating"));
            }
        } catch (SQLException e) {
            System.err.println("Error executing query 2: " + e.getMessage());
        }
        System.out.println("\n");

        // Query 3: Gets feedback memo with ride passenger and driver details, ordered by feedback ID
            String sql3 = "SELECT F.feedback_ID, F.memo AS feedback_comment, P.p_fullname AS passenger_name, " +
                        "D.d_fullname AS driver_name, R.ride_ID " +
                        "FROM Feedbck F, Ride R, Passenger P, Driver D " +
                        "WHERE F.ride_ID = R.ride_ID " +
                        "AND F.passenger_ID = P.passenger_ID " +
                        "AND F.driver_ID = D.driver_ID " +
                        "ORDER BY F.feedback_ID";

        try (PreparedStatement stmt = conn.prepareStatement(sql3);
        ResultSet rs = stmt.executeQuery()) {
        System.out.println("Feedback Details:");
        System.out.println("\n");
        while (rs.next()) {
        System.out.printf(
        "Feedback ID: %d, Comment: %s, Passenger Name: %s, Driver Name: %s, Ride ID: %d%n",
        rs.getInt("feedback_ID"), rs.getString("feedback_comment"),
        rs.getString("passenger_name"), rs.getString("driver_name"),
        rs.getInt("ride_ID")
        );
        }
        } catch (SQLException e) {
        System.err.println("Error executing feedback details query: " + e.getMessage());
        }
        System.out.println("\n");

        // Query 4: Count Total Rides by Each Driver
            String sql4 = "SELECT Driver.d_fullname AS driver_name, " +
                        "COUNT(Ride.ride_id) AS total_rides " +
                        "FROM Driver, Ride " +
                        "WHERE Driver.driver_id = Ride.driver_id " +
                        "GROUP BY Driver.d_fullname " +
                        "ORDER BY total_rides DESC";

        try (PreparedStatement stmt = conn.prepareStatement(sql4);
        ResultSet rs = stmt.executeQuery()) {
        System.out.println("Total Rides by Each Driver:");
        System.out.println("\n");
        while (rs.next()) {
        System.out.printf(
        "Driver Name: %s, Total Rides: %d%n",
        rs.getString("driver_name"),
        rs.getInt("total_rides")
        );
        }
        } catch (SQLException e) {
        System.err.println("Error executing total rides query: " + e.getMessage());
        }
        System.out.println("\n");
 
        // Query 5: Find All Drivers Who Have Given Rides to a Specific Passenger
            String passengerName = "John Doe";
            String sql5 = "SELECT DISTINCT Driver.d_fullname AS driver_name " +
                          "FROM Driver, Ride, Passenger " +
                          "WHERE Driver.driver_id = Ride.driver_id " +
                          "AND Ride.passenger_ID = Passenger.passenger_ID " +
                          "AND Passenger.p_fullname = ?";

        try (PreparedStatement stmt = conn.prepareStatement(sql5)) {
        stmt.setString(1, passengerName); // Set the passenger name dynamically

        try (ResultSet rs = stmt.executeQuery()) {
        System.out.println("Drivers Who Have Given Rides to " + passengerName + ":");
        System.out.println("\n");
        while (rs.next()) {
            System.out.printf("Driver Name: %s%n", rs.getString("driver_name"));
        }
        }
        } catch (SQLException e) {
            System.err.println("Error executing query for drivers who served a specific passenger: " + e.getMessage());
        }
        System.out.println("\n");
    }

    // Pause method to simulate waiting for user input to continue
    private static void pause() {
        Scanner scanner = new Scanner(System.in);
        System.out.println("\nPress Enter to continue...");
        scanner.nextLine();
    }

    // Main method to start the program
    public static void main(String[] args) {
        Connection conn1 = null;

        try {
            // registers Oracle JDBC driver - though this is no longer required
            Class.forName("oracle.jdbc.OracleDriver");

            String dbURL1 = "jdbc:oracle:thin:cyoussef/12146366@oracle12c.scs.ryerson.ca:1521:orcl12c";
            conn1 = DriverManager.getConnection(dbURL1);
            if (conn1 != null) {
                System.out.println("Connected with connection #1");

                // Start the menu after a successful connection
                mainMenu(conn1);
            }

        } catch (ClassNotFoundException ex) {
            ex.printStackTrace();
        } catch (SQLException ex) {
            ex.printStackTrace();
        } finally {
            try {
                if (conn1 != null && !conn1.isClosed()) {
                    conn1.close();
                }

            } catch (SQLException ex) {
                ex.printStackTrace();
            }
        }
    }
}
