package SellShares.src.main.java.com.cs673.t1;

import java.io.IOException;
import java.math.BigDecimal;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import com.cs673.t1.dao.XCHGDao;

/**
 * Servlet implementation class SellSharesController
 * @author Mubarak
 * 
 */
public class SellSharesController extends HttpServlet {
	private static final long serialVersionUID = 1L;
       
    /**
     * @see HttpServlet#HttpServlet()
     */
    public SellSharesController() {
        super();
    }

	/**
	 * @see HttpServlet#doGet(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		
		response.setContentType("application/json");
		
		String symbol = request.getParameter("symbol");
		String username = request.getParameter("username");
		String portfolio_name = request.getParameter("portfolio_name");
		Integer requested_num_of_shares = Integer.parseInt(request.getParameter("requested_num_of_shares"));
		//BigDecimal cost = new BigDecimal(request.getParameter("cost"));
		BigDecimal total_cost = new BigDecimal(request.getParameter("total_cost"));
		
		XCHGDao dao = new XCHGDao();
		
		try {
			dao.addCash(username, portfolio_name, total_cost);
			dao.updateTransaction(portfolio_name, username, symbol, requested_num_of_shares, total_cost);
			dao.updatePerformance(username, portfolio_name, symbol, requested_num_of_shares);
		} catch (Exception e) {
			e.printStackTrace();
		}
		


				
		
		
		String message = "success";
		response.getWriter().append("{ \"message\": " + message +  "}");
		
		//response.getWriter().append("Served at: ").append(request.getContextPath());
	}



}
