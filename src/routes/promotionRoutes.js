const express = require('express');
const controller = require('../controllers/promotionController');
const { authRequired, requireRole } = require('../middlewares/authMiddleware');

const router = express.Router();

router.get('/', controller.list);
router.post('/', authRequired, requireRole('ceo', 'admin'), controller.create);
router.patch('/:id/approve', authRequired, requireRole('admin'), controller.approve);
router.patch('/:id/deny', authRequired, requireRole('admin'), controller.deny);
router.delete('/:id', authRequired, requireRole('ceo', 'admin'), controller.remove);

module.exports = router;
