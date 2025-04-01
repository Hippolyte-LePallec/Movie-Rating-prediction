import { NextFunction, Response, Request } from 'express'
import jwt from 'jsonwebtoken'

export const verifyJWT = (req: Request, res: Response, next: NextFunction) => {
  const authHeader = req.headers.authorization
  if (authHeader) {
    const token = authHeader.split(' ')[1]
    const decodedToken = jwt.verify(
      token,
      process.env.JWT_SECRET as jwt.Secret,
    ) as {
      userId: string
    }
    const userId = decodedToken.userId
    req.query = {
      userId: userId,
    }
    next()
  } else {
    res.sendStatus(401)
  }
}
