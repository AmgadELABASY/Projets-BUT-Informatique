
/*
                    données dérivées
*/

/*
Cette procédure prend en paramètres un ID d'un étudiant ex: 1, et 
elle RETOUNE le relevé des notes de l'étudiant
*/

create or replace function notes_e(in int,out e_matiere varchar,out e_controle varchar,
out e_note decimal(4,2))
 returns setof record as
$$
    declare
    


        curs2 cursor for select matiere,controle,note FROM Matiere 
        natural join Controle
            natural join Notes 
            natural join Etudiant where etudiant_id=$1;

    begin
        
        open curs2;
            loop 
                fetch curs2 into e_matiere,e_controle,e_note;
                exit when not found;
                return next;
                 
            end loop;

        close curs2;
        
        
    

    end;   

$$ language plpgsql;

/*
Cette procédure prend en paramètres un nom de group ex:'Cygnus', et
elle RETOUNE le relevé des notes d'un group 
*/

create or replace function notes_g(in gr varchar,
out e_nom varchar,
out e_prenom varchar,
out e_matiere varchar,
out e_controle varchar,
out e_note decimal(4,2)
)
 returns setof record as
$$
    declare
    


        curs2 cursor for select nom,prenom,matiere,controle,note FROM Matiere 
        natural join Controle
            natural join Notes 
            natural join Etudiant where g = (select distinct g from etudiant 
                                                where g=$1);

    begin
        
        open curs2;
            loop 
                fetch curs2 into e_nom,e_prenom,e_matiere,e_controle,e_note;
                exit when not found;
                return next;
                 
            end loop;

        close curs2;
        
        
    end;   

$$ language plpgsql;


/*
            Restriction d'accès aux données
*/

/*
CETTE vue RETOURNE une table de 3 colonnes matiere,controle,note
elle permet seulement aux étudiants de consulter ses notes.

*/
create or replace view notes_etudiant as

SELECT matiere,controle,note
FROM Matiere natural join Controle
natural join Notes natural join Etudiant
WHERE etudiant_id ::name =current_user;

/*
Cette procédure prend en paramètres l'ID de l'étudiant et 
RETOURNE ses notes dans toutes les matières
Elle permet de voir seulement ses notes à lui 

*/

CREATE or REPLACE FUNCTION notes_e_security(in int,out e_matiere varchar,out e_controle varchar,
out e_note decimal(4,2))
AS $$
  BEGIN
     select matiere,controle,note 
     into e_matiere,e_controle,e_note
     FROM Matiere 
        natural join Controle
            natural join Notes 
            natural join Etudiant WHERE session_user=lower((select nom from etudiant 
                                                    where etudiant_id=$1)::name);
  END;
$$ language PLpgSQL
    security definer;
   

/*
Cette procédure prend en paramètres le nom de l'enseignant, 
l'id de l'etudiant,id de contrôle et la note qu'il veut saisir
Elle lui permet de saisir les notes d'un étudiant dans la table notes
*/

CREATE or REPLACE FUNCTION saisie_notes_con(in nom_ens varchar,in et_id int,in cont_id int,in e_note decimal(4,2))
returns record AS $$
  begin
  if nom_ens::name =current_user then 
    insert into notes (etudiant_id,controle_id,note) values (et_id,cont_id,e_note);
    end if;
    return null;
             

end;
  
$$ language plpgsql
    security definer;


/*

*/

create or replace function check_note() 
returns trigger
AS $$ 
BEGIN
    IF NEW.note < 0 THEN 
        NEW.note=0;
    END IF;
    IF NEW.note >20 THEN
        NEW.note=20; 
    END IF;
    return NEW; 
END;

$$ language plpgsql;

create trigger check_note_trig
    before insert or update 
        ON notes for each row
    execute procedure check_note();

