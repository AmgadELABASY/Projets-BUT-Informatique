
public class Nombre extends Expression {

	
	/*
	 * variable d'instance
	 */
	private int valeurNombre;
	
	
	/*
	 * Constructeur champ à champ 
	 */
	public Nombre(int nombre) {
		this.valeurNombre = nombre;
	}
	
	public int valeur() {
		return this.valeurNombre;
	}
	
	/*
	 * toString
	 */
	
	public String toString() {
		String c = ""+this.valeurNombre;
		return c;
	}

	
}












