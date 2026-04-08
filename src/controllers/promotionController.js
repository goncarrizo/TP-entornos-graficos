const ApiError = require('../utils/ApiError');
const {
  getPromotions,
  createPromotion,
  updatePromotionStatus,
  deletePromotion,
} = require('../models/promotionModel');

async function list(req, res, next) {
  try {
    const data = await getPromotions();
    res.json(data);
  } catch (error) {
    next(error);
  }
}

async function create(req, res, next) {
  try {
    const { airline_id, title, description, discount_percent, is_active } = req.body;
    if (!airline_id || !title || !discount_percent) {
      throw new ApiError(400, 'airline_id, title y discount_percent son obligatorios');
    }

    const id = await createPromotion({
      airlineId: airline_id,
      title,
      description: description || '',
      discountPercent: discount_percent,
      isActive: is_active ? 1 : 0,
    });

    res.status(201).json({ message: 'Promocion creada (pendiente de aprobacion)', id });
  } catch (error) {
    next(error);
  }
}

async function approve(req, res, next) {
  try {
    await updatePromotionStatus(req.params.id, 'approved');
    res.json({ message: 'Promocion aprobada' });
  } catch (error) {
    next(error);
  }
}

async function deny(req, res, next) {
  try {
    await updatePromotionStatus(req.params.id, 'denied');
    res.json({ message: 'Promocion denegada' });
  } catch (error) {
    next(error);
  }
}

async function remove(req, res, next) {
  try {
    await deletePromotion(req.params.id);
    res.json({ message: 'Promocion eliminada' });
  } catch (error) {
    next(error);
  }
}

module.exports = { list, create, approve, deny, remove };
