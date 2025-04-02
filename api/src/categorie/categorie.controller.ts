import { Request, Response } from 'express'
import prisma from '../client'

export const getCategories = async (req: Request, res: Response) => {
  try {
    const categories = await prisma.categorie.findMany()
    res.status(200).send(categories)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const getCategoryById = async (req: Request, res: Response) => {
  try {
    const category = await prisma.categorie.findUnique({
      where: {
        id_categorie: parseInt(req.params.id_categorie),
      },
    })
    res.status(200).send(category)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const createCategory = async (req: Request, res: Response) => {
  try {
    const category = await prisma.categorie.create({
      data: req.body,
    })
    res.status(201).send(category)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const updateCategory = async (req: Request, res: Response) => {
  try {
    const category = await prisma.categorie.update({
      where: {
        id_categorie: parseInt(req.params.id_categorie),
      },
      data: req.body,
    })
    res.status(200).send(category)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const deleteCategory = async (req: Request, res: Response) => {
  try {
    const category = await prisma.categorie.delete({
      where: {
        id_categorie: parseInt(req.params.id_categorie),
      },
    })
    res.status(204).send([])
  } catch(error) {
    res.status(500).send({error: error})
  }
}