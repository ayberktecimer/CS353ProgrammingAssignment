import java.sql.*;

public class DBconnection {
    public static void main(String[] args) {
        String username = "xxxx";
        String password = "xxxx";
        String jdbc = "jdbc:mysql://dijkstra.ug.bcc.bilkent.edu.tr:3306/ayberktecimer";

        try {

            Class.forName("com.mysql.cj.jdbc.Driver");
            System.out.println("Connecting to a selected database...");
            Connection connection = DriverManager.getConnection(jdbc, username,password);
            System.out.println("Connected database successfully...\n");

            Statement statement = connection.createStatement();

            System.out.println("Starting to remove previous tables if exists...");
            statement.execute("DROP TABLE IF EXISTS apply, company, student");
            System.out.println("Removed previous tables...\n");

            String studentDefinition = "CREATE TABLE student " +
                    "(sid CHAR(12)," +
                    "sname VARCHAR(50)," +
                    "bdate DATE," +
                    "telno CHAR(10)," +
                    "scity VARCHAR(20)," +
                    "year CHAR(20)," +
                    "gpa FLOAT," +
                    "PRIMARY KEY(sid))";

            System.out.println("Starting to create student table...");
            statement.execute(studentDefinition);
            System.out.println("Student table is created...\n");

            String companyDefinition = "CREATE TABLE company " +
                    "(cid CHAR(8), " +
                    "cname VARCHAR(20), " +
                    "quota INT," +
                    "PRIMARY KEY(cid))";

            System.out.println("Starting to create company table...");
            statement.execute(companyDefinition);
            System.out.println("Company table is created...\n");


            String applyDefinition = "CREATE TABLE apply " +
                    "(sid CHAR(12), " +
                    "cid CHAR(8)," +
                    "PRIMARY KEY(sid,cid)," +
                    "FOREIGN KEY (sid) REFERENCES student(sid)," +
                    "FOREIGN KEY (cid) REFERENCES company(cid))";

            System.out.println("Starting to create apply table...");
            statement.execute(applyDefinition);
            System.out.println("Apply table is created...\n");


            String studentValues = "INSERT INTO student VALUES" +
                    "(21000001, 'Ayse', '1995-05-10', 5321113333, 'Ankara', 'senior', 2.75)," +
                    "(21000002, 'Ali', '1995-05-10', 5355361234, 'Istanbul', 'junior', 3.44)," +
                    "(21000003, 'Veli', '1995-05-10', 5553214455, 'Istanbul', 'freshman', 2.36)," +
                    "(21000004, 'John', '1995-05-10', 5335336622, 'Chicago', 'freshman', 2.55);";


            System.out.println("Starting to insert values to student table...");
            statement.execute(studentValues);
            System.out.println("Values are inserted to student table...\n");

            String companyValues = "INSERT INTO company VALUES" +
                    "('C101', 'Tubitak', 2)," +
                    "('C102', 'Aselsan', 5)," +
                    "('C103', 'Havelsan', 3)," +
                    "('C104', 'Microsoft', 5)," +
                    "('C105', 'Merkez Bankasi', 3)," +
                    "('C106', 'Tai', 4)," +
                    "('C107', 'Milsoft', 2);";


            System.out.println("Starting to insert values to company table...");
            statement.execute(companyValues);
            System.out.println("Values are inserted to company table...\n");

            String applyValues = "INSERT INTO apply VALUES" +
                    "(21000001, 'C101')," +
                    "(21000001, 'C102')," +
                    "(21000001, 'C103')," +
                    "(21000002, 'C101')," +
                    "(21000002, 'C105')," +
                    "(21000003, 'C104')," +
                    "(21000003, 'C105')," +
                    "(21000004, 'C107');";
            System.out.println("Starting to insert values to apply table...");
            statement.execute(applyValues);
            System.out.println("Values are inserted to apply table...\n");

            String studentQuery = "SELECT * FROM student";
            ResultSet rs = statement.executeQuery(studentQuery);
            System.out.println("sid \t sname \t bdate \t telno \t scity \t year \t gpa");
            while (rs.next()) {
                String sid = rs.getString("sid");
                String sname =rs.getString("sname");
                String bdate = rs.getString("bdate");
                String telno =rs.getString("telno");
                String scity = rs.getString("scity");
                String year =rs.getString("year");
                String gpa =rs.getString("gpa");
                System.out.println(sid +" "+ sname +" "+ bdate +" "+ telno +" "+ scity +" "+ year+" "+ gpa +" ");
            }

        } catch (SQLException | ClassNotFoundException e) {
            System.err.println("Error Statement or Connection Failed!!!!");
            e.printStackTrace();
        }
    }
}
