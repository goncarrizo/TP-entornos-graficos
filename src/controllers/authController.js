const bcrypt = require('bcryptjs');
const jwt = require('jsonwebtoken');
const ApiError = require('../utils/ApiError');
const { createUser, findUserByEmail, findUserById } = require('../models/userModel');

async function register(req, res, next) {
  try {
    const { name, email, password } = req.body;

    const existing = await findUserByEmail(email);
    if (existing) {
      throw new ApiError(400, 'El email ya esta registrado');
    }

    const passwordHash = await bcrypt.hash(password, 10);

    // Para el TP simulamos validacion de email como aprobada automaticamente.
    const userId = await createUser({
      name,
      email,
      passwordHash,
      role: 'customer',
      emailVerified: 1,
    });

    const user = await findUserById(userId);

    res.status(201).json({ message: 'Usuario registrado correctamente', user });
  } catch (error) {
    next(error);
  }
}

async function login(req, res, next) {
  try {
    const { email, password } = req.body;

    const user = await findUserByEmail(email);
    if (!user) {
      throw new ApiError(401, 'Credenciales invalidas');
    }

    const isBcryptHash = user.password_hash.startsWith('$2a$')
      || user.password_hash.startsWith('$2b$')
      || user.password_hash.startsWith('$2y$');

    const validPassword = isBcryptHash
      ? await bcrypt.compare(password, user.password_hash)
      : password === user.password_hash;
    if (!validPassword) {
      throw new ApiError(401, 'Credenciales invalidas');
    }

    if (!user.email_verified) {
      throw new ApiError(403, 'Debes validar tu email antes de ingresar');
    }

    const token = jwt.sign(
      { id: user.id, email: user.email, role: user.role, name: user.name },
      process.env.JWT_SECRET,
      { expiresIn: '8h' }
    );

    res.json({
      message: 'Login exitoso',
      token,
      user: { id: user.id, name: user.name, email: user.email, role: user.role },
    });
  } catch (error) {
    next(error);
  }
}

async function me(req, res, next) {
  try {
    const user = await findUserById(req.user.id);
    if (!user) {
      throw new ApiError(404, 'Usuario no encontrado');
    }
    res.json(user);
  } catch (error) {
    next(error);
  }
}

function logout(req, res) {
  // Con JWT en frontend solo removemos token del cliente.
  res.json({ message: 'Logout exitoso (cliente debe borrar token)' });
}

module.exports = { register, login, me, logout };
