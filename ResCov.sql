/*==============================================================*/
/* Nom de SGBD :  MySQL 5.0                                     */
/* Date de création :  11/23/2020 4:35:21 PM                    */
/*==============================================================*/


drop table if exists Commande;

drop table if exists Plats;

/*==============================================================*/
/* Table : Commande                                             */
/*==============================================================*/
create table Commande
(
   Id_p                 int,
   Id_c                 int not null,
   Email                varchar(254),
   adresse              varchar(254),
   date_c               datetime,
   Nom                  varchar(254),
   Prenom               varchar(254),
   primary key (Id_c)
);

/*==============================================================*/
/* Table : Plats                                                */
/*==============================================================*/
create table Plats
(
   Id_p                 int not null,
   Nom_p                varchar(254),
   Prix_p               float,
   Ingredients_p        varchar(254),
   Descrip_p            varchar(254),
   img_p                varchar(254),
   primary key (Id_p)
);

alter table Commande add constraint FK_Association_1 foreign key (Id_p)
      references Plats (Id_p) on delete restrict on update restrict;

