
set datestyle to "ISO , DMY";

drop table if exists notes;
drop table if exists controle;
drop table if exists matiere;
drop table if exists etudaint;


create table etudiant(

	etudiant_id serial primary key,
	nom varchar(50),
	prenom varchar(50)
);
-- pour ajouter le group de chaque étudiant;	
alter table etudiant add g varchar;



create table matiere(
	matiere_id varchar(10) 
			primary key,
	matiere varchar
);



create table controle(
	controle_id serial primary key,
	matiere_id varchar(10) references matiere(matiere_id),
	controle varchar
);




create table notes(
	etudiant_id int references etudiant(etudiant_id),
	controle_id int references controle(controle_id),
	note decimal(4,2),
	primary key (etudiant_id,controle_id)
);

create table enseignant(
	ens_id serial primary key,
	ens_nom varchar(50),
	matiere_id varchar(10) references matiere(matiere_id),
	controle_id int references controle(controle_id)
);


create or replace procedure insert_etudiant(
_nom varchar(50),_prenom varchar(50))

as $$ 

INSERT INTO etudiant(nom,prenom) VALUES (_nom,
_prenom);

$$ LANGUAGE SQL;



create or replace procedure insert_matiere(_matiere_id varchar(10),
	_matiere varchar)

as $$ 

INSERT INTO matiere(matiere_id,matiere) VALUES (_matiere_id,_matiere);

$$ LANGUAGE SQL; 


create or replace procedure insert_controle(_matiere_id,_controle varchar)

as $$

INSERT INTO controle(matiere_id,controle ) VALUES (_matiere_id,_controle);

$$ language SQL;




create or replace procedure insert_notes(_etudiant_id int,_controle_id int,_note decimal(4,2))

as $$

INSERT INTO notes(etudiant_id,controle_id,note) VALUES (_etudiant_id,_controle_id,_note);

$$ language SQL;
