const express = require('express');
const controller = require('../controllers/reservationController');
const validate = require('../middlewares/validate');
const { reservationValidator } = require('../middlewares/validators');
const { authRequired, requireRole } = require('../middlewares/authMiddleware');

const router = express.Router();

router.get('/mine', authRequired, requireRole('customer', 'admin'), controller.listMine);
router.post('/', authRequired, requireRole('customer', 'admin'), reservationValidator, validate, controller.create);
router.patch('/:id/cancel', authRequired, controller.cancel);

module.exports = router;
