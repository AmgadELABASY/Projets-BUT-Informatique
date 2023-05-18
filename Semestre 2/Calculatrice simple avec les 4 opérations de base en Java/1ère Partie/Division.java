
public class Division extends Operation {


	public Division(int nombre1, int nombre2) {
		super(nombre1, nombre2);
		
	}
	
	
	public Division(Nombre objet_nombre1,Nombre objet_nombre2) {
		super(objet_nombre1,objet_nombre2);
	}
	
	
	  
	 /*
	* cette méthode délègue une exception pour permettre au programme de 
	*continuer son fonctionnement en cas de division par 0(en cas d'erreur de type
	ArithmeticException)
	 */
	 
	@Override
	public int valeur() throws ArithmeticException {
		if(super.getNombre2() == 0) {
			throw new ArithmeticException();
		}
		else {
			return super.getNombre1() / super.getNombre2();
		}
		
		
		}
		
		
	
	public String toString() {
		return this.getNombre1() + " / " + this.getNombre2();
	}
	
	

}
