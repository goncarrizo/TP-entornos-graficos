const express = require('express');
const controller = require('../controllers/airlineController');
const { authRequired, requireRole } = require('../middlewares/authMiddleware');

const router = express.Router();

router.get('/', controller.listAirlines);
router.post('/', authRequired, requireRole('admin'), controller.create);
router.put('/:id', authRequired, requireRole('admin'), controller.update);
router.delete('/:id', authRequired, requireRole('admin'), controller.remove);

module.exports = router;
