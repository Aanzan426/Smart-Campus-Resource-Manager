# Smart Campus Resource Manager

## Problem Statement
Universities face challenges in efficiently managing shared resources such as classrooms, laboratories, and equipment. The goal is to build a **Smart Campus Resource Manager** that enables administrators to allocate, track, and control resource usage while preventing booking conflicts and maintaining data integrity.

This project focuses on **backend logic, database design, and real-world constraint handling** using **PHP and MySQL**, with a lightweight frontend for interaction.

---

## Core Requirements

### Frontend (HTML / CSS / JavaScript)
- Forms for booking resources (rooms, labs, equipment).
- Calendar or list-based view of existing bookings.
- Client-side validation for missing inputs and basic date/time sanity checks.
- Optional UI-level conflict warnings (server remains the final source of truth).

### Backend (PHP + MySQL)
- Database structure:
  - `users`
  - `resources`
  - `bookings`
- CRUD operations for resources and bookings.
- Conflict prevention (double booking protection) using:
  - server-side overlap checking
  - MySQL transactions for safe, atomic booking operations
  - indexing/constraints where applicable

- Authentication using PHP sessions.

---

## Data Integrity & Architecture
- Use prepared statements for all database queries.
- Use MySQL transactions to ensure atomic booking operations.
- Modular PHP structure (separate DB connection, auth, and booking logic).

---

## Security Constraints
- Input sanitization and output escaping.
- Access control for booking and administrative actions.

---

## Deliverables
- `index.html` — booking interface
- `style.css` — responsive layout
- `booking.js` — validation and calendar/list rendering
- `db.sql` — schema for users, resources, bookings
- `auth.php`, `booking.php` — backend logic

    
