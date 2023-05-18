
public class Soustraction extends Operation {
	
	
	public Soustraction(Expression op1, Expression op2) {
		super(op1,op2);
		
	}
	@Override
	public int valeur() {
		
		return super.getOperande1().valeur()-super.getOperande2().valeur();
	}
	
	public String toString() {
		return "("+super.getOperande1() + " - " +super.getOperande2()+")";
	}
	


}
