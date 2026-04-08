const express = require('express');
const controller = require('../controllers/flightController');
const validate = require('../middlewares/validate');
const { flightValidator } = require('../middlewares/validators');
const { authRequired, requireRole } = require('../middlewares/authMiddleware');

const router = express.Router();

router.get('/', controller.list);
router.get('/:id', controller.detail);
router.post('/', authRequired, requireRole('ceo', 'admin'), flightValidator, validate, controller.create);
router.put('/:id', authRequired, requireRole('ceo', 'admin'), flightValidator, validate, controller.update);
router.delete('/:id', authRequired, requireRole('ceo', 'admin'), controller.remove);

module.exports = router;
