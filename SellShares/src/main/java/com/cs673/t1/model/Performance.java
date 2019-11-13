package SellShares.src.main.java.com.cs673.t1.model;

import java.math.BigDecimal;
import java.time.LocalDateTime;

/**
 * 
 * @author Mubarak
 *
 */
public class Performance {

	
	private String username;
	private String portfolio_name;
	private int portfolio_id;
	private String symbol;
	private String company_name;
	private BigDecimal buy_price;
	private LocalDateTime buy_date;
	private int shares;
	private BigDecimal current_price;
	private String currency;
	private BigDecimal gain_loss;
	private BigDecimal port_nav;

	public Performance(String username, String portfolio_name, int portfolio_id, String symbol, String company_name,
			BigDecimal buy_price, LocalDateTime buy_date, int shares, BigDecimal current_price, String currency,
			BigDecimal gain_loss, BigDecimal port_nav) {
		super();
		this.username = username;
		this.portfolio_name = portfolio_name;
		this.portfolio_id = portfolio_id;
		this.symbol = symbol;
		this.company_name = company_name;
		this.buy_price = buy_price;
		this.buy_date = buy_date;
		this.shares = shares;
		this.current_price = current_price;
		this.currency = currency;
		this.gain_loss = gain_loss;
		this.port_nav = port_nav;
	}

	public String getUsername() {
		return username;
	}

	public void setUsername(String username) {
		this.username = username;
	}

	public String getPortfolio_name() {
		return portfolio_name;
	}

	public void setPortfolio_name(String portfolio_name) {
		this.portfolio_name = portfolio_name;
	}

	public int getPortfolio_id() {
		return portfolio_id;
	}

	public void setPortfolio_id(int portfolio_id) {
		this.portfolio_id = portfolio_id;
	}

	public String getSymbol() {
		return symbol;
	}

	public void setSymbol(String symbol) {
		this.symbol = symbol;
	}

	public String getCompany_name() {
		return company_name;
	}

	public void setCompany_name(String company_name) {
		this.company_name = company_name;
	}

	public BigDecimal getBuy_price() {
		return buy_price;
	}

	public void setBuy_price(BigDecimal buy_price) {
		this.buy_price = buy_price;
	}

	public LocalDateTime getBuy_date() {
		return buy_date;
	}

	public void setBuy_date(LocalDateTime buy_date) {
		this.buy_date = buy_date;
	}

	public int getShares() {
		return shares;
	}

	public void setShares(int shares) {
		this.shares = shares;
	}

	public BigDecimal getCurrent_price() {
		return current_price;
	}

	public void setCurrent_price(BigDecimal current_price) {
		this.current_price = current_price;
	}

	public String getCurrency() {
		return currency;
	}

	public void setCurrency(String currency) {
		this.currency = currency;
	}

	public BigDecimal getGain_loss() {
		return gain_loss;
	}

	public void setGain_loss(BigDecimal gain_loss) {
		this.gain_loss = gain_loss;
	}

	public BigDecimal getPort_nav() {
		return port_nav;
	}

	public void setPort_nav(BigDecimal port_nav) {
		this.port_nav = port_nav;
	}

	@Override
	public String toString() {
		return "Performance [username=" + username + ", portfolio_name=" + portfolio_name + ", portfolio_id="
				+ portfolio_id + ", symbol=" + symbol + ", company_name=" + company_name + ", buy_price=" + buy_price
				+ ", buy_date=" + buy_date + ", shares=" + shares + ", current_price=" + current_price + ", currency="
				+ currency + ", gain_loss=" + gain_loss + ", port_nav=" + port_nav + "]";
	}

}
