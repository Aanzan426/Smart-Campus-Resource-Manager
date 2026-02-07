# Smart Campus Resource Manager

## Problem Statement
Educational institutions rely on shared infrastructure such as classrooms, laboratories, halls, and equipment. Traditional booking systems either allow unrestricted time selection or require manual approval, leading to scheduling conflicts, unrealistic reservations, unfair priority allocation, and poor visibility of real availability.

The **Smart Campus Resource Manager** implements a rule-driven booking system where users do not manually enter time.  
Instead, the server dynamically generates only valid booking slots using operational constraints:

- resource working hours
- maximum usage duration
- cleanup buffer time
- real-world current time
- existing confirmed bookings

The system guarantees:

- impossible bookings cannot exist
- past slots cannot be reserved
- double booking is structurally prevented
- expired bookings automatically lose blocking authority
- availability always reflects real time

This project focuses on **real-world constraint modelling, scheduling logic, and database integrity** using PHP and MySQL with a lightweight frontend.

---

## System Philosophy
The system does **not trust user-entered time values**.

Instead the backend:

1. Calculates valid slots
2. Removes expired slots
3. Removes already booked slots
4. Presents only feasible options

Booking becomes a **selection problem, not an input problem**.

---

## Core Functional Requirements

### Resource Management (Admin)
- Create resources
- Update resource parameters
- Activate / deactivate resources
- Delete resources
- View resources by category or globally

Each resource defines its own operational rules:

- opening time
- closing time
- maximum booking duration
- automatic cleanup buffer

---

### Booking System
- Weekday-based booking (Monday–Friday)
- Automatic slot generation from resource timing rules
- Only future real-time slots selectable
- First-come-first-serve confirmation
- Overlap prevention at query level
- Unique booking code generation
- Optional notes / purpose

---

### Booking Lifecycle

| State     | Meaning |
|----------|------|
| Active   | Slot exists in the future |
| Expired  | Slot time has passed |
| Cancelled| User/admin revoked booking |

Expired bookings remain stored but no longer block availability.

---

### Authentication
- Admin login session
- User verification before booking
- Session-based identity tracking
- Role-restricted actions

---

## Data Integrity & Architecture
- Prepared statements for all database queries
- Overlap detection queries
- Real-time availability filtering
- Foreign key relationships between users, resources, bookings
- Modular PHP structure (config, auth, logic separation)

---

## Security Constraints
- Input validation
- Output escaping
- Session-based authorization
- Server-side time enforcement (client cannot fake time)

---

## Deliverables
- Admin console for governance
- Slot-based booking interface
- Booking search & filtering
- Database schema (`users`, `resources`, `bookings`)
- Modular PHP backend
