const Input = ({ submit, input, url }) => {
	function handleSubmit(e) {
		return submit(e);
  }

	return (
		<form onSubmit={handleSubmit}>
			<input type="text" onInput={input} value={url} placeholder="Paste Video URL" />
			<button>Submit</button>
		</form>
	);
};

export default Input;