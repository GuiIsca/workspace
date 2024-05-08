//Criação da bd
use CBD

//Criação da collection
db.createCollection('Pintor')


// Inserir individualmente
db.Pintor.insert({
  id_pintor: 1,  
  nome_pintor: "Leonardo Fernando",
  data_nascimento: ISODate("1992-04-15"),
  contatos_telefonicos: "923-556-799"
})

// Inserir em simultâneo
db.Pintor.insertMany([
  { id_pintor: 2, nome_pintor: "Pedro van Gogh", data_nascimento: ISODate("1993-03-30"), contatos_telefonicos: "987-655-378" },
  { id_pintor: 3, nome_pintor: "Joao Picasso", data_nascimento: ISODate("1991-10-25"), contatos_telefonicos: "931-242-533" },
  { id_pintor: 4, nome_pintor: "Claudia Monet", data_nascimento: ISODate("2000-11-14"), contatos_telefonicos: "972-181-959" }
])

// Inserir com formato em array 
db.Pintor.insertMany([
  { id_pintor: 9, nome_pintor: "Frank Michael", data_nascimento: ISODate("1996-05-25"), contatos_telefonicos: ["917-345-889", "943-111-737"] },
  { id_pintor: 10, nome_pintor: "Gonçalo Costa", data_nascimento: ISODate("2000-12-28"), contatos_telefonicos: ["937-755-678", "981-444-251"] },
  { id_pintor: 11, nome_pintor: "Fernando Aguia", data_nascimento: ISODate("1993-07-24"), contatos_telefonicos: ["924-351-318", "955-141-666"] }
])


//ver Pintor
db.Pintor.find()

//Igual a
db.Pintor.find({ nome_pintor: "Ricardo Santiago" })

//OR e Maior Que
db.Pintor.find({
  $or: [{data_nascimento: { $gt: new Date("2001-01-01") }},
        {id_pintor: { $gt: 10 }}]
    })

//AND,Maior/Menor ou igual que
db.Pintor.find({
  $and:[ {data_nascimento: { $gte: new Date("1999-01-01") }},
  {data_nascimento: { $lte: new Date("1999-12-31") }}]
  })
    
//NOT
db.Pintor.find({
  id_pintor: { $not: { $eq: 11 } }
})

//AND e Diferente
db.Pintor.find({
  $and: [{ nome_pintor: { $ne: "Joao Picasso" } },
         { nome_pintor: { $ne: "Miguel Pedro" } }]
})

//Consulta com array 1
db.Pintor.find({ contatos_telefonicos: { $size: 2 } })

//Consulta com array 2
db.Pintor.find({ "contatos_telefonicos.0": { $regex: "^92" } })



     

              



