const jwt = require('jsonwebtoken');
const ApiError = require('../utils/ApiError');

function authRequired(req, res, next) {
  const authHeader = req.headers.authorization;
  if (!authHeader || !authHeader.startsWith('Bearer ')) {
    return next(new ApiError(401, 'Token no proporcionado'));
  }

  const token = authHeader.split(' ')[1];

  try {
    const payload = jwt.verify(token, process.env.JWT_SECRET);
    req.user = payload;
    return next();
  } catch (error) {
    return next(new ApiError(401, 'Token invalido o expirado'));
  }
}

function requireRole(...roles) {
  return (req, res, next) => {
    if (!req.user || !roles.includes(req.user.role)) {
      return next(new ApiError(403, 'No tenes permisos para esta accion'));
    }
    return next();
  };
}

module.exports = { authRequired, requireRole };
