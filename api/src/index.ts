// Fichier : src/index.ts
import express from 'express'
import swaggerUi from 'swagger-ui-express'
import YAML from 'yamljs'
import path from 'path'
import { userRouter } from './user/user.router'
import { mediaRouter } from './media/media.router'
import { genreRouter } from './genre/genre.router'
import { ratingRouter } from './rating/rating.router'
import { categorieRouter } from './categorie/categorie.router'
import { personneRouter } from './personne/personne.router'
import { crewRouter } from './crew/crew.router'
import { mediaGenreRouter } from './media_genre/mediaGenre.router'
import { principaleRouter } from './principale/principale.router'

export const app = express()
const port = process.env.PORT || 3000

// Charger la spécification Swagger
const swaggerDocument = YAML.load(path.join(__dirname, './swagger.yaml'))

app.use('/api-docs', swaggerUi.serve, swaggerUi.setup(swaggerDocument))
app.use(express.json())

app.use(userRouter)
app.use(mediaRouter)
app.use(genreRouter)
app.use(ratingRouter)
app.use(categorieRouter)
app.use(personneRouter)
app.use(crewRouter)
app.use(mediaGenreRouter)
app.use(principaleRouter)

export const server = app.listen(port)

export function stopServer() {
  server.close()
}
