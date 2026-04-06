---
name: mongoose-backend
description: "Use when: reviewing Node.js/Express backend code, validating Mongoose models, testing routes/controllers, or checking async/await patterns in database operations"
---

# Backend Mongoose Code Review & Testing

**Purpose**: Quick workflow for reviewing, validating, and testing Mongoose-backed Node.js backend code across models, controllers, routes, and tests.

## When to Use This Skill
- Reviewing Mongoose model definitions and schema validation
- Auditing async/await patterns in controllers and routes
- Writing or reviewing tests for API endpoints
- Checking validation logic and error handling
- Ensuring consistent code patterns across the codebase

---

## Workflow Steps

### 1. **Models - Schema & Validation**
   - [ ] Check schema fields are properly typed (`String`, `Number`, `Date`, `ObjectId`, etc.)
   - [ ] Verify required fields are marked (`required: true`)
   - [ ] Confirm custom validators are implemented (e.g., email, min/max length)
   - [ ] Look for pre-save hooks if data transformation is needed
   - [ ] Ensure indexes are set on frequently queried fields

### 2. **Routes - Definition & Structure**
   - [ ] Verify HTTP methods match intended actions (GET, POST, PUT, DELETE)
   - [ ] Confirm route paths follow RESTful conventions (`/api/resource`, `/api/resource/:id`)
   - [ ] Check that route handlers are properly imported from controllers
   - [ ] Validate request parameter extraction (`:id`, query params, body)
   - [ ] Ensure authentication/authorization middleware is applied

### 3. **Controllers - Async/Await & Error Handling**
   - [ ] **Async/Await Pattern**: All database operations use `async/await`, not `.then().catch()`
   - [ ] Verify `await` is used with Mongoose queries (`.findById()`, `.save()`, `.updateOne()`, etc.)
   - [ ] Check try/catch blocks wrap async operations
   - [ ] Confirm errors are caught and returned with appropriate status codes
   - [ ] Look for proper error messages and logging
   - [ ] Validate response structure (consistent JSON format)
   - [ ] **Mongoose Error Handling**: Check for specific error types:
     - `CastError` (invalid ObjectId format) → 400 Bad Request
     - `ValidationError` (schema validation failed) → 400 Bad Request
     - `MongoError` (duplicate key, connection issues) → appropriate status code
     - `general Error` (unexpected) → 500 Internal Server Error

### 4. **Middleware - Authentication, Validation & Logging**
   - [ ] **Authentication Middleware**: Verify JWT/token extraction and validation
     - Token comes from `Authorization` header (format: `Bearer <token>`)
     - Invalid/expired tokens return 401 Unauthorized
     - User ID is attached to `req.user` for downstream use
   - [ ] **Validation Middleware**: Check for input sanitization
     - Body parameters validated before reaching controller
     - Query/params validated for type and format
     - Error messages passed to next middleware/controller
   - [ ] **Logging Middleware**: Proper request/response logging
     - Request logs include method, path, user ID (if authenticated)
     - Error logs include stack traces (development only)
     - No sensitive data (passwords, tokens) logged
   - [ ] **Error Handler Middleware**: Centralized error handling
     - Global `app.use((err, req, res, next) => {...})` in place
     - Catches async errors and formats consistent response
     - Handles 404s and unexpected errors gracefully

### 5. **Validation - Input & Business Logic**
   - [ ] Request body validation before database operation
   - [ ] Check for duplicate prevention (e.g., unique email on signup)
   - [ ] Verify JWT/token validation if authentication is required
   - [ ] Confirm status/state transitions are logical
   - [ ] Look for permission checks (user owns resource before update/delete)

### 6. **Testing - Unit & Integration**
   - [ ] Test model validators (valid & invalid inputs)
   - [ ] Test API endpoints for success paths (POST, GET, PUT, DELETE)
   - [ ] Test error cases (invalid ID, missing fields, unauthorized access)
   - [ ] Verify async operations complete before assertions
   - [ ] Mock or use test database for isolation
   - [ ] Check response codes match expectations (201, 200, 400, 401, 404, etc.)

### 7. **Quality Checks**
   - [ ] No unhandled promise rejections
   - [ ] No console.log left in production code (use proper logging)
   - [ ] Connection strings/secrets not hardcoded
   - [ ] Database transactions used if multiple operations should succeed together

---

## Quick Decision Tree

**Am I reviewing a model file?**
→ Go to **Step 1: Models - Schema & Validation**

**Am I reviewing routes?**
→ Go to **Step 2: Routes - Definition & Structure**

**Am I reviewing a controller?**
→ Go to **Step 3: Controllers - Async/Await & Error Handling** (critical focus on async/await & Mongoose errors)

**Am I reviewing middleware?**
→ Go to **Step 4: Middleware - Authentication, Validation & Logging**

**Am I writing tests?**
→ Go to **Step 6: Testing - Unit & Integration**

**Am I doing a full code review?**
→ Follow all steps in sequence.

---

## Common Patterns to Look For

### ✓ Good: Async/Await Pattern
```javascript
async function getUserById(req, res) {
  try {
    const user = await User.findById(req.params.id);
    if (!user) return res.status(404).json({ error: 'User not found' });
    res.json(user);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
}
```

### ✗ Bad: Promise Chain (outdated)
```javascript
function getUserById(req, res) {
  User.findById(req.params.id)
    .then(user => res.json(user))
    .catch(error => res.status(500).json({ error: error.message }));
}
```

### ✓ Good: Validation Before Save
```javascript
async function createUser(req, res) {
  try {
    const { email, name } = req.body;
    if (!email || !name) return res.status(400).json({ error: 'Missing fields' });
    
    const user = new User({ email, name });
    await user.save();
    res.status(201).json(user);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
}
```

### ✓ Good: Mongoose Error Handling
```javascript
async function updateUser(req, res) {
  try {
    const user = await User.findByIdAndUpdate(req.params.id, req.body, { new: true, runValidators: true });
    if (!user) return res.status(404).json({ error: 'User not found' });
    res.json(user);
  } catch (error) {
    // Handle Mongoose-specific errors
    if (error.name === 'CastError') {
      return res.status(400).json({ error: 'Invalid user ID format' });
    }
    if (error.name === 'ValidationError') {
      return res.status(400).json({ error: Object.values(error.errors).map(e => e.message) });
    }
    if (error.code === 11000) { // Duplicate key
      return res.status(400).json({ error: 'Email already exists' });
    }
    res.status(500).json({ error: 'Internal server error' });
  }
}
```

### ✓ Good: Authentication Middleware
```javascript
function authMiddleware(req, res, next) {
  try {
    const token = req.headers.authorization?.split(' ')[1];
    if (!token) return res.status(401).json({ error: 'No token provided' });
    
    const decoded = jwt.verify(token, process.env.JWT_SECRET);
    req.user = decoded;
    next();
  } catch (error) {
    res.status(401).json({ error: 'Invalid or expired token' });
  }
}
```

---

## Success Criteria

✅ **Review is complete when:**
- All async operations use `async/await` with proper error handling
- Validation happens before and after database operations
- Tests cover happy paths and error cases
- Response formats are consistent
- No unhandled promise rejections
- Security checks (auth, ownership) are in place
