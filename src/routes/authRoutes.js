const express = require('express');
const { register, login, me, logout } = require('../controllers/authController');
const validate = require('../middlewares/validate');
const { registerValidator, loginValidator } = require('../middlewares/validators');
const { authRequired } = require('../middlewares/authMiddleware');

const router = express.Router();

router.post('/register', registerValidator, validate, register);
router.post('/login', loginValidator, validate, login);
router.get('/me', authRequired, me);
router.post('/logout', authRequired, logout);

module.exports = router;
