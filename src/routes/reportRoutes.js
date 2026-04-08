const express = require('express');
const { getSales, getOccupancy, getGeneral } = require('../controllers/reportController');
const { authRequired, requireRole } = require('../middlewares/authMiddleware');

const router = express.Router();

router.get('/sales', authRequired, requireRole('admin', 'ceo'), getSales);
router.get('/occupancy', authRequired, requireRole('admin', 'ceo'), getOccupancy);
router.get('/general', authRequired, requireRole('admin'), getGeneral);

module.exports = router;
