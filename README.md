# Ride and Pick-Up Database Management System (DBMS) “Voiture”

**Introduction**

The ride and pick-up database management system (DBMS) “Voiture”, is a database designed to handle and manage data associated with transportation services. Its main goal is to effectively store, retrieve, and manage data for rides, drivers, and users. "Voiture" tracks information about passengers/drivers, keeps accurate transaction records, and offers real-time updates that ensure smooth coordination between drivers and passengers. It provides features such as ride scheduling, fare calculations, passenger preferences, and customer feedback management, making it a reliable solution for modern transportation needs.

**Applications**

This system aims to organize and store crucial data related to the service itself. This includes:
   - Ride Details: Ride-related data such as the rider, driver, locations to and from, payment, real-time tracking of trip, estimated arrival times and statuses.
   - Rider Information: Details about the riders such as their payment history, rating and trip history.
   - Driver Information: Details about the drivers such as driver's license, rating, vehicle information, and driving history.
   - Scheduling and Dispatch: The system effectively matches drivers who are available with riders based on factors like location, availability, and preferences.
   - Payment Management: Handling multiple payment methods, calculating prices and discounts, as well as providing invoices to riders
   - Customer Support and Feedback: Gathering opinions from drivers and passengers in order to guarantee ongoing service improvement and satisfaction.

**Functionality**

Important functionalities to consider when creating the ride and pick-up DBMS include:
  - Data Storage: Rider, driver, vehicle and trip information must be stored effectively and in an organized manner.
  - Procurement Data Management: Queries must be quickly obtained to find relevant information i.e. finding available drivers or retrieving previous ride details.
  - Data Security and Protection: Encrypting personal rider, driver, and payment information to prevent any security breaches.
  - Concurrency Control: Ensuring that simultaneous requests from riders ordering rides, as well as drivers accepting rides are not interfering in any way to prevent disputes.
  - Handling Transactions: Guaranteeing that payments, ride bookings, or other requests are handled as atomic transactions, and are either processed entirely or not at all.
  - Recovery and Backup: Utilizing procedures to restore and retrieve rider, ride and driver data in the event of a system failure.

**Entities**

- Rider: Represents individuals who use the service to book rides.
  - Attributes: Rider ID, name, contact information, banking information and rating

- Driver: Represents individuals who offer ride services.
  - Attributes: Driver ID, name, driver's license number, banking information, and rating
  
- Vehicle: Represents the vehicles owned by drivers.
  - Attributes: Driver ID, Vehicle ID, model, license plate, capacity and type

- Ride: Represents individual rides booked by riders.
  - Attributes: Driver ID, rider ID, payment ID, Start Location, end location, start time, and end time.

- Payment: Represents the financial transactions for each ride.
  - Attributes: Payment ID, initial cost, tip amount, total cost (with tax), payment method and payment status.

**Relationships**

  - Each RIDER record is related to the RIDE records and PAYMENT records
  - Each DRIVER record is related to the RIDE records, one VEHICLE record, and PAYMENT records
  - Each PAYMENT record is related to RIDE records

**Constraints**

  - Each DRIVER record should be related to one VEHICLE record
  - Every ID (student, rider, payment, vehicle) should be uniquely identifiable in its record and other records

**Conclusion**

The "Voiture" ride and pick-up DBMS effectively addresses the needs of modern transportation services by offering a comprehensive solution for managing rides, drivers, vehicles, and payments. Some key features include real-time updates, secure data handling, and efficient scheduling and dispatch. The well-defined entities and relationships within the database support seamless operations, while its robust functionality, such as payment management, customer feedback, and transaction handling, makes it a reliable and scalable platform for transportation businesses.
