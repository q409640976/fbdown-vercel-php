const Loading = () => (
	<div className="loading">
		<img src="/assets/squidward.gif" alt="Dancing Squidward" />
		Please wait ...
	</div>
);

const Result = ({ loading, result }) => {
	
	if (loading) {
		return <Loading />;
	}

	return result?.status === 'success'
		? (
			<>
				<div className="result">
					<img src={result.data.image} alt={result.data.title} />
					<div className="title">{result.data.title}</div>
				</div>
				<video src={result.data.video} controls />
				<p className="credit">&hearts; @bramaudi</p>
			</>
		)
		: result
			? <div className="error">Sorry, can't get the video!</div>
			: null;
};

export default Result;