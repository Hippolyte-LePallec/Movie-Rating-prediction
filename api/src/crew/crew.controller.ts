import { Request, Response } from 'express'
import prisma from '../client'

export const getCrew = async (req: Request, res: Response) => {
  try {
    const crews = await prisma.crew.findMany({
      include: {
        directeurs: {
          include: {
            personne: true
          }
        },
        ecrivains: {
          include: {
            personne: true
          }
        }
      }
    })
    res.status(200).send(crews)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const getCrewById = async (req: Request, res: Response) => {
  try {
    const id = parseInt(req.params.id_crew);
    
    if (isNaN(id)) res.status(400).send({ error: 'ID invalide' })
    const crew = await prisma.crew.findUnique({
      where: {
        id_crew: id,
      },
      include: {
        directeurs: {
          include: {
            personne: true
          }
        },
        ecrivains: {
          include: {
            personne: true
          }
        }
      }
    })
    
    if (!crew) res.status(404).send({ error: 'Crew non trouvé' })
    
    res.status(200).send(crew)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const createCrew = async (req: Request, res: Response) => {
  try {
    const { directeurs = [], ecrivains = [] } = req.body;
    
    const crew = await prisma.crew.create({
      data: {
        directeurs: {
          create: directeurs.map((directeur: { personneId: number }) => ({
            personneId: directeur.personneId
          }))
        },
        ecrivains: {
          create: ecrivains.map((ecrivain: { personneId: number }) => ({
            personneId: ecrivain.personneId
          }))
        }
      },
      include: {
        directeurs: {
          include: {
            personne: true
          }
        },
        ecrivains: {
          include: {
            personne: true
          }
        }
      }
    });
    
    res.status(201).send(crew);
  } catch(error) {
    console.error("Erreur lors de la création du crew:", error);
    res.status(500).send({error: error});
  }
}

export const updateCrew = async (req: Request, res: Response) => {
  try {
    const id = parseInt(req.params.id_crew);
    
    if (isNaN(id)) res.status(400).send({ error: 'ID invalide' })
    
    const crewExists = await prisma.crew.findUnique({
      where: { id_crew: id }
    });
    
    if (!crewExists) res.status(404).send({ error: 'Crew non trouvé' })
    
    const { nom_crew, directeurs = [], ecrivains = [] } = req.body;
    
    await prisma.directeur.deleteMany({
      where: { crewId: id }
    });
    
    await prisma.ecrivain.deleteMany({
      where: { crewId: id }
    });
    
    const crew = await prisma.crew.update({
      where: { id_crew: id },
      data: {
        directeurs: {
          create: directeurs.map((directeur: { id_personne: number }) => ({
            personneId: directeur.id_personne
          }))
        },
        ecrivains: {
          create: ecrivains.map((ecrivain: { id_personne: number }) => ({
            personneId: ecrivain.id_personne
          }))
        }
      },
      include: {
        directeurs: {
          include: {
            personne: true
          }
        },
        ecrivains: {
          include: {
            personne: true
          }
        }
      }
    });
    
    res.status(200).send(crew)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const deleteCrew = async (req: Request, res: Response) => {
  try {
    const id = parseInt(req.params.id_crew);
    
    if (isNaN(id)) res.status(400).send({ error: 'ID invalide' })
    
    const crewExists = await prisma.crew.findUnique({
      where: { id_crew: id }
    });
    
    if (!crewExists) res.status(404).send({ error: 'Crew non trouvé' })
    
    await prisma.directeur.deleteMany({
      where: { crewId: id }
    });
    
    await prisma.ecrivain.deleteMany({
      where: { crewId: id }
    });
    
    const crew = await prisma.crew.delete({
      where: {
        id_crew: id,
      },
    })
    
    res.status(204).send([])
  } catch(error) {
    res.status(500).send({error: error})
  }
}